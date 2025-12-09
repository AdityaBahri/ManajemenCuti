<?php

namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use App\Models\User;
use App\Models\Division;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $data = [];

        // --- 1. DATA PRIBADI (SEMUA USER) ---
        // HRD dan Admin juga mungkin ingin melihat data cuti pribadinya di masa depan
        $sickLeaveId = \App\Models\LeaveType::where('name', 'LIKE', '%Sakit%')->value('id');

        $data['my_quota'] = $user->current_annual_leave_quota;
        $data['my_pending'] = LeaveRequest::where('user_id', $user->id)->where('status', 'pending')->count();
        $data['my_approved'] = LeaveRequest::where('user_id', $user->id)->where('status', 'approved')->count();
        $data['my_last_request'] = LeaveRequest::where('user_id', $user->id)->latest()->first();
        
        // Data detail user panel
        $data['user'] = [
            'quota' => $user->current_annual_leave_quota,
            'sick_leave_count' => LeaveRequest::where('user_id', $user->id)
                                    ->where('leave_type_id', $sickLeaveId)
                                    ->count(),
            'total_requests' => LeaveRequest::where('user_id', $user->id)->count(),
            'division_name' => $user->division->name ?? '-',
            'division_head' => $user->division->head->name ?? '-',
        ];

        // --- 2. DATA KHUSUS ADMIN (System Overview) ---
        if ($user->isAdmin()) {
            // Flatten data agar mudah diakses di view ($data['total_users'])
            $data['total_users'] = User::count();
            $data['total_divisions'] = Division::count();
            $data['total_heads'] = User::where('role', 'division_head')->count();
            $data['total_staff'] = User::where('role', 'employee')->count();
            
            $data['admin'] = [
                'active_users' => User::where('is_active', true)->count(),
                'inactive_users' => User::where('is_active', false)->count(),
                'monthly_requests' => LeaveRequest::whereMonth('created_at', now()->month)
                                        ->whereYear('created_at', now()->year)
                                        ->count(),
                'pending_approvals' => LeaveRequest::whereIn('status', ['pending', 'approved_by_leader'])->count(),
                'ineligible_users' => User::where('join_date', '>', now()->subYear())
                                        ->orderBy('join_date', 'desc')
                                        ->get(),
            ];
        }

        // --- 3. DATA KHUSUS KETUA DIVISI (Team Overview) ---
        if ($user->isDivisionHead() && $user->ledDivision) {
            $divId = $user->ledDivision->id;
            
            $data['head'] = [
                'total_requests_in' => LeaveRequest::whereHas('user', fn($q) => $q->where('division_id', $divId))
                                        ->where('user_id', '!=', $user->id)
                                        ->count(),
                'pending_verification' => LeaveRequest::whereHas('user', fn($q) => $q->where('division_id', $divId))
                                            ->where('status', 'pending')
                                            ->where('user_id', '!=', $user->id)
                                            ->count(),
                'members' => User::where('division_id', $divId)->get(),
                'team_count' => User::where('division_id', $divId)->count(),
                'team_pending' => LeaveRequest::whereHas('user', fn($q) => $q->where('division_id', $divId))
                                        ->where('status', 'pending')->count(),
                'on_leave_week' => User::where('division_id', $divId)
                    ->whereHas('leaveRequests', function($q) {
                        $startOfWeek = now()->startOfWeek();
                        $endOfWeek = now()->endOfWeek();
                        $q->where('status', 'approved')
                          ->where(function($query) use ($startOfWeek, $endOfWeek) {
                              $query->whereBetween('start_date', [$startOfWeek, $endOfWeek])
                                    ->orWhereBetween('end_date', [$startOfWeek, $endOfWeek])
                                    ->orWhere(function($sub) use ($startOfWeek, $endOfWeek) {
                                        $sub->where('start_date', '<', $startOfWeek)
                                            ->where('end_date', '>', $endOfWeek);
                                    });
                          });
                    })->get()
            ];
        }

        // --- 4. DATA KHUSUS HRD (Operational Overview) ---
        if ($user->isHrd()) {
            $data['total_employees'] = User::count(); // Tambahkan ini agar tidak error di view HRD
            $data['total_divisions'] = Division::count(); // Tambahkan ini juga
            
            // Global Pending khusus HRD
            $data['global_pending'] = LeaveRequest::where('status', 'approved_by_leader')
                                    ->orWhere(function($q) {
                                        $q->where('status', 'pending')
                                          ->whereHas('user', fn($u) => $u->whereIn('role', ['division_head', 'hrd', 'admin']));
                                    })->count();
            
            // Sedang Cuti Hari Ini
            $data['on_leave_today'] = LeaveRequest::where('status', 'approved')
                ->whereDate('start_date', '<=', now())
                ->whereDate('end_date', '>=', now())
                ->count();

            $data['hrd'] = [
                'monthly_requests' => LeaveRequest::whereMonth('created_at', now()->month)
                                        ->whereYear('created_at', now()->year)
                                        ->count(),
                'pending_final' => $data['global_pending'], // Reuse variable
                'on_leave_month' => User::whereHas('leaveRequests', function($q) {
                        $q->where('status', 'approved')
                          ->where(function($query) {
                              $query->whereMonth('start_date', now()->month)
                                    ->orWhereMonth('end_date', now()->month);
                          });
                    })->limit(10)->get(),
                'divisions' => Division::withCount('members')->get(),
            ];
        }

        return view('dashboard', compact('data'));
    }
}