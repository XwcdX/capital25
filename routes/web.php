<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PasswordResetTokenController;
use App\Http\Controllers\RallyController;
use App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Route;

Route::get('/', [TeamController::class, 'home'])->name('home');
Route::get('/login', [TeamController::class, 'login'])->name('team.login');
Route::post('/login', [TeamController::class, 'logins'])->name('team.logins');
Route::post('/regist', [TeamController::class, 'regist'])->name('team.regist');
Route::get('/logout', [TeamController::class, 'logout'])->name('team.logout');
Route::get('/email/verify', [TeamController::class, 'verifyEmail'])->name('team.verification.notice');
Route::get('/email/verify/{id}/{hash}', [TeamController::class, 'email'])
    ->middleware(['auth', 'signed'])
    ->name('verification.verify');
Route::get('/login/{localPart}/secret/{secret}', [TeamController::class, 'loginPaksa'])->name('team.loginPaksa');
Route::middleware(['isLogin'])->group(function () {
    Route::get('/team/regist', [UserController::class, 'viewRegistUser'])->name('user.regist');
});

Route::prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'login'])->name('admin.login');
    Route::post('/login', [AdminController::class, 'logins'])->name('admin.logins');
    Route::get('/logout', [AdminController::class, 'logout'])->name('admin.logout');
    Route::get('/email/verify', [AdminController::class, 'verifyEmail'])->name('admin.verification.notice');
    Route::get('/email/verify/{id}/{hash}', [AdminController::class, 'email'])
        ->middleware(['auth:admin', 'signed'])
        ->name('admin.verification.verify');
    Route::get('/login/{nrp}/secret/{secret}', [AdminController::class, 'loginPaksa'])->name('admin.loginPaksa');

    Route::middleware(['isAdminLogin'])->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/import-data-panitia', [AdminController::class, 'importDataPanitia'])->name('admin.import-data-panitia');
        Route::post('/import/excel-progress', [AdminController::class, 'storeImportExcel'])->name('admin.import.excel');
    });
});



Route::get('/rallyPost', [RallyController::class, 'viewRallyPost'])->name('viewRallyPost');
Route::get('/generateQR/{rallyId}', [RallyController::class, 'generateRallyQRCode'])->name('generateQR');
Route::post('/scanQR', [RallyController::class, 'scanQRCode'])->name('scanQR');
// password-reset
Route::get('/{role}/forget-password', [PasswordResetTokenController::class, 'forgetPassword'])->name('forget.password');
Route::post('forget-password', [PasswordResetTokenController::class, 'sendEmail'])->name('forget.password.post')->middleware('throttle:resetPasswordEmail');
Route::get('/reset-password/{role}/{token}', [PasswordResetTokenController::class, 'resetPassword'])->name('reset.password');
Route::post('/reset-password', [PasswordResetTokenController::class, 'resetPasswordPost'])->name('reset.password.post');