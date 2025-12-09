<?php

namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use App\Models\LeaveType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class LeaveRequestController extends Controller
{
    /**
     * Menampilkan riwayat cuti pengguna.
     */
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        $leaveRequests = LeaveRequest::where('user_id', $user->id)
            ->with(['type', 'leaderApprover', 'hrdApprover'])
            ->latest()
            ->paginate(10);

        return view('leave_requests.index', compact('leaveRequests'));
    }

    /**
     * Menampilkan form pengajuan cuti.
     */
    public function create()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $leaveTypes = LeaveType::all();
        
        return view('leave_requests.create', compact('leaveTypes', 'user'));
    }

    /**
     * Memproses penyimpanan pengajuan cuti.
     */
    public function store(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $request->validate([
            'leave_type_id' => 'required|exists:leave_types,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string|max:1000',
            'medical_certificate' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $leaveType = LeaveType::find($request->leave_type_id);
        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);
        
        // Hitung hari kerja (Senin-Jumat)
        $totalDays = 0;
        $period = CarbonPeriod::create($startDate, $endDate);
        foreach ($period as $date) {
            if (!$date->isWeekend()) {
                $totalDays++;
            }
        }

        if ($totalDays <= 0) {
            return back()->withErrors(['start_date' => 'Anda tidak dapat mengajukan cuti hanya pada akhir pekan.'])->withInput();
        }

        // Cek Overlap
        $overlap = LeaveRequest::where('user_id', $user->id)
            ->where('status', '!=', 'cancelled')
            ->where('status', '!=', 'rejected')
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('start_date', [$startDate, $endDate])
                      ->orWhereBetween('end_date', [$startDate, $endDate])
                      ->orWhere(function ($q) use ($startDate, $endDate) {
                          $q->where('start_date', '<=', $startDate)
                            ->where('end_date', '>=', $endDate);
                      });
            })
            ->exists();

        if ($overlap) {
            return back()->withErrors(['start_date' => 'Anda sudah memiliki pengajuan cuti pada tanggal tersebut.'])->withInput();
        }

        // Cek Kuota Cuti Tahunan
        if ($leaveType->name === 'Cuti Tahunan') {
            if ($user->current_annual_leave_quota < $totalDays) {
                return back()->withErrors(['leave_type_id' => 'Sisa kuota cuti tahunan tidak mencukupi.'])->withInput();
            }
            if ($startDate->diffInDays(now(), false) > -3) {
                 return back()->withErrors(['start_date' => 'Pengajuan Cuti Tahunan minimal H-3.'])->withInput();
            }
        }

        // Cek Cuti Sakit
        $filePath = null;
        if ($leaveType->name === 'Cuti Sakit') {
            if (!$request->hasFile('medical_certificate')) {
                return back()->withErrors(['medical_certificate' => 'Surat dokter wajib diunggah.'])->withInput();
            }
            // Maksimal H+3 setelah sakit
            if (now()->diffInDays($startDate) > 3 && $startDate->isPast()) {
                 return back()->withErrors(['start_date' => 'Pengajuan Cuti Sakit maksimal H+3 dari tanggal sakit.'])->withInput();
            }
            $filePath = $request->file('medical_certificate')->store('medical_certificates', 'public');
        }
        
        LeaveRequest::create([
            'user_id' => $user->id,
            'leave_type_id' => $leaveType->id,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'total_days' => $totalDays,
            'reason' => $request->reason,
            'status' => 'pending',
            'medical_certificate_path' => $filePath,
            'contact_address_during_leave' => $request->address ?? $user->address,
            'emergency_number' => $request->phone_number ?? $user->phone_number,
        ]);

        return redirect()->route('leave-requests.index')->with('success', 'Pengajuan cuti berhasil dikirim.');
    }

    public function show(LeaveRequest $leaveRequest)
    {
        $this->authorize('view', $leaveRequest);
        return view('leave_requests.show', compact('leaveRequest'));
    }

    public function cancel(LeaveRequest $leaveRequest)
    {
        if (! Gate::allows('cancel-leave-request', $leaveRequest)) {
            return back()->withErrors('Pembatalan gagal.');
        }
        $leaveRequest->update(['status' => 'cancelled']);
        return redirect()->route('leave-requests.index')->with('success', 'Pengajuan dibatalkan.');
    }
}