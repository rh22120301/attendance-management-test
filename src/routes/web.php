<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\AdminController;

Route::middleware('auth')-> get('/', [GeneralController::class, 'attendance']);
Route::middleware('auth')-> post('/clockin', [GeneralController::class, 'clockIn'])->name('attendance.clockIn');
Route::middleware('auth')-> post('/clockout', [GeneralController::class, 'clockOut'])->name('attendance.clockOut');
Route::middleware('auth')-> post('/breakStart', [GeneralController::class, 'breakStart'])->name('attendance.breakStart');
Route::middleware('auth')-> post('/breakEnd', [GeneralController::class, 'breakEnd'])->name('attendance.breakEnd');

Route::middleware('auth')-> get('/attendanceList', [GeneralController::class, 'attendanceList']);
Route::middleware('auth')-> get('/attendanceList/{id}', [GeneralController::class, 'showDetail']);
Route::middleware('auth')-> post('/attendanceList/{id}/update', [GeneralController::class, 'updateDetail']);
Route::middleware('auth')-> get('/stampCorrectionRequest', [GeneralController::class, 'stampCorrectionRequest']);
Route::middleware('auth')-> post('/attendanceList/{id}/correction', [GeneralController::class, 'correction']);

// 管理者
Route::get('/admin/login', function () {return view('admin.login');})->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login.post');
Route::middleware('auth')-> get('/admin/attendanceList', [AdminController::class, 'attendanceList']);
Route::middleware('auth')-> get('/admin/staff', [AdminController::class, 'staff']);
Route::middleware('auth')-> get('/admin/stampCorrectionRequest', [AdminController::class, 'stampCorrectionRequest']);
Route::middleware('auth')->get('/admin/stampCorrectionRequest/{id}',[AdminController::class, 'approveConfirmation']);
Route::middleware('auth')->post('/admin/request/{id}/approve', [AdminController::class, 'approve']);
Route::middleware('auth')-> get('/admin/attendance/staff/{user}',[AdminController::class, 'staffMonthly'])->name('admin.attendance.staff');
Route::middleware('auth')->get('/admin/attendance/{id}',[AdminController::class, 'showDetail'])->name('admin.attendance.show');
Route::post('/admin/attendance', [AdminController::class, 'store'])->name('admin.attendance.store');
Route::middleware('auth')->post('/admin/attendance/{id}/correction',[AdminController::class, 'correction'])->name('admin.attendance.correction');
