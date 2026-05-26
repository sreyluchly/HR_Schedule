<?php

use App\Http\Controllers\ShiftController;

Route::get('/shifts', [ShiftController::class, 'employeeDashboard'])->name('shifts.employee');
Route::post('/shifts/store', [ShiftController::class, 'store'])->name('shifts.store');
Route::post('/shifts/claim/{id}', [ShiftController::class, 'claim'])->name('shifts.claim');

Route::get('/hr/dashboard', [ShiftController::class, 'hrDashboard'])->name('hr.dashboard');
Route::post('/hr/approve/{id}', [ShiftController::class, 'approve'])->name('hr.approve');
Route::post('/hr/reject/{id}', [ShiftController::class, 'reject'])->name('hr.reject');