<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LeaveRequestController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\ProfileController;

// Public routes
Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// PWA Manifest
Route::get('/manifest.json', function () {
    return response()->json([
        'name' => 'Attendance System',
        'short_name' => 'Attendance',
        'start_url' => '/',
        'display' => 'standalone',
        'background_color' => '#ffffff',
        'theme_color' => '#3b82f6',
        'icons' => [
            [
                'src' => '/icon-192.png',
                'sizes' => '192x192',
                'type' => 'image/png'
            ],
            [
                'src' => '/icon-512.png',
                'sizes' => '512x512',
                'type' => 'image/png'
            ]
        ]
    ]);
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Profile routes (accessible by both users and admins)
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    
    // User routes
    Route::get('/dashboard', [AttendanceController::class, 'dashboard'])->name('dashboard');
    Route::get('/scan-qr', [AttendanceController::class, 'scanQr'])->name('qr.scan');
    Route::post('/check-in', [AttendanceController::class, 'processCheckIn'])->name('check.in');
    Route::get('/attendance-confirmation', [AttendanceController::class, 'showConfirmation'])->name('attendance.confirmation');
    Route::get('/history', [AttendanceController::class, 'history'])->name('history');
    
    // Leave Requests
    Route::resource('leave-requests', LeaveRequestController::class)->except(['show', 'edit', 'update']);
    
    // Admin routes
    Route::middleware('admin')->prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/qr-code', [AdminController::class, 'showWorkplaceQrCode'])->name('admin.qr');
        Route::post('/qr-code/refresh', [AdminController::class, 'refreshWorkplaceQrCode'])->name('admin.qr.refresh');
        Route::get('/reports', [AdminController::class, 'reports'])->name('admin.reports');
        Route::get('/analytics', [AdminController::class, 'analytics'])->name('admin.analytics');
        Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
        
        // Leave Management
        Route::get('/leave-requests', [AdminController::class, 'leaveRequests'])->name('admin.leave-requests');
        Route::post('/leave-requests/{leaveRequest}/approve', [AdminController::class, 'approveLeave'])->name('admin.leave.approve');
        Route::post('/leave-requests/{leaveRequest}/reject', [AdminController::class, 'rejectLeave'])->name('admin.leave.reject');
        
        // Settings
        Route::get('/settings', [SettingController::class, 'index'])->name('admin.settings');
        Route::post('/settings', [SettingController::class, 'update'])->name('admin.settings.update');
        
        // Audit Logs
        Route::get('/audit-logs', [AuditLogController::class, 'index'])->name('admin.audit-logs');
        
        // Exports
        Route::get('/export-pdf', [AdminController::class, 'exportPdf'])->name('admin.export.pdf');
        Route::get('/export-excel', [ExportController::class, 'exportExcel'])->name('admin.export.excel');
        Route::get('/export-csv', [ExportController::class, 'exportCsv'])->name('admin.export.csv');
    });
});