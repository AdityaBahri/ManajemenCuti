<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// --- Import Controllers ---
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DivisionController;
use App\Http\Controllers\Admin\LeaveApprovalController;
use App\Http\Controllers\LeaveRequestController;
use App\Http\Controllers\DashboardController;

// Halaman Depan
Route::get('/', function () {
    return view('welcome');
});

// --- DASHBOARD (Akses Semua User yang Login) ---
// Menggunakan DashboardController untuk menyiapkan data statistik sesuai role
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// --- GROUP GLOBAL (Harus Login) ---
Route::middleware('auth')->group(function () {
    
    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- GROUP 1: PENGAJUAN CUTI (Hanya Karyawan & Ketua Divisi) ---
    // Middleware 'role.applicant' akan memblokir Admin & HRD
    Route::middleware(['role.applicant'])->group(function () {
        Route::resource('leave-requests', LeaveRequestController::class);
        // Route khusus untuk membatalkan cuti
        Route::post('leave-requests/{leaveRequest}/cancel', [LeaveRequestController::class, 'cancel'])->name('leave-requests.cancel');
    });
    
    // --- GROUP 2: APPROVAL / VERIFIKASI (Hanya Admin, HRD, Ketua Divisi) ---
    // Middleware 'role.approver' akan memblokir Karyawan Biasa
    Route::middleware(['role.approver'])->group(function () {
        Route::get('/approvals', [LeaveApprovalController::class, 'index'])->name('approvals.index');
        Route::post('/approvals/{leaveRequest}/approve', [LeaveApprovalController::class, 'approve'])->name('approvals.approve');
        Route::post('/approvals/{leaveRequest}/reject', [LeaveApprovalController::class, 'reject'])->name('approvals.reject');
    });
});

// --- GROUP 3: ADMIN PANEL (Hanya Super Admin) ---
// Middleware 'can:access-admin-panel' menggunakan Gate (di AuthServiceProvider)
// Prefix URL: /admin/... (misal: /admin/users)
// Prefix Nama Route: admin... (misal: admin.users.index)
Route::middleware(['auth', 'verified', 'can:access-admin-panel'])->prefix('admin')->name('admin.')->group(function () {
    
    // Manajemen Pengguna (CRUD)
    Route::resource('users', UserController::class); 

    // Manajemen Divisi (CRUD)
    Route::resource('divisions', DivisionController::class);
    
    // Fitur Manajemen Anggota Divisi
    Route::post('divisions/{division}/add-member', [DivisionController::class, 'addMember'])->name('divisions.addMember');
    Route::post('divisions/remove-member/{user}', [DivisionController::class, 'removeMember'])->name('divisions.removeMember');
});

require __DIR__.'/auth.php';