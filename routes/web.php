<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AdminController;

// Public routes
Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // User routes
    Route::get('/dashboard', [AttendanceController::class, 'dashboard'])->name('dashboard');
    Route::get('/qr-code', [AttendanceController::class, 'showQrCode'])->name('qr.show');
    Route::get('/scan-qr', [AttendanceController::class, 'scanQr'])->name('qr.scan');
    Route::post('/check-in', [AttendanceController::class, 'processCheckIn'])->name('check.in');
    Route::get('/history', [AttendanceController::class, 'history'])->name('history');
    
    // Admin routes
    Route::middleware('admin')->prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/reports', [AdminController::class, 'reports'])->name('admin.reports');
        Route::get('/export-pdf', [AdminController::class, 'exportPdf'])->name('admin.export.pdf');
        Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    });
});