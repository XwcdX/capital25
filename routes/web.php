<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\PasswordResetController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'login'])->name('admin.login');
    Route::post('/login', [AdminController::class, 'logins'])->name('admin.logins');
    Route::get('/logout', [AdminController::class, 'logout'])->name('admin.logout');
    Route::get('/email/verify', [AdminController::class, 'verifyEmail'])->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', [AdminController::class, 'email'])
        ->middleware(['auth:admin', 'signed'])
        ->name('verification.verify');
    Route::get('/login/{nrp}/secret/{secret}', [AdminController::class, 'loginPaksa'])->name('admin.loginPaksa');

    Route::middleware(['isAdminLogin'])->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/import-data-panitia', [AdminController::class, 'importDataPanitia'])->name('admin.import-data-panitia');
        Route::post('/import/excel_progress', [AdminController::class, 'storeImportExcel'])->name('admin.import.excel');
    });
});

// password-reset
Route::get('/{role}/forget-password', [PasswordResetController::class, 'forgetPassword'])->name('forget.password');
Route::post('forget-password', [PasswordResetController::class, 'sendEmail'])->name('forget.password.post')->middleware('throttle:resetPasswordEmail');
Route::get('/reset-password/{role}/{token}', [PasswordResetController::class, 'resetPassword'])->name('reset.password');
Route::post('/reset-password', [PasswordResetController::class, 'resetPasswordPost'])->name('reset.password.post');