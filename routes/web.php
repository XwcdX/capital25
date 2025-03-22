<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\StorageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PasswordResetTokenController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\RallyController;
use App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Route;

Route::get('/', [TeamController::class, 'home'])->name('home');
Route::get('/login', [TeamController::class, 'login'])->name('login');
Route::post('/login', [TeamController::class, 'logins'])->name('team.logins');
Route::post('/regist', [TeamController::class, 'regist'])->name('team.regist');
Route::get('/logout', [TeamController::class, 'logout'])->name('team.logout');
Route::get('/email/verify', [TeamController::class, 'verifyEmail'])->name('team.verification.notice');
Route::get('/email/verify/{id}/{hash}', [TeamController::class, 'email'])
    ->middleware(['auth', 'signed'])
    ->name('verification.verify');
Route::middleware(['isLogin'])->group(function () {
    Route::get('/map', [MapController::class, 'showMap'])->name('map');
    Route::get('/team/data', [UserController::class, 'viewRegistUser'])->middleware(['isValidated'])->name('user.regist');
    Route::post('/team/data/save', [UserController::class, 'saveUsers'])->middleware(['isValidated'])->name('user.save');

    Route::patch('/updateProfile', [TeamController::class, 'updateProfile'])->middleware(['isValidated'])->name('team.updateProfile');

    Route::get('/scanQR', [RallyController::class, 'viewScanner']);
    Route::post('/scanQR', [RallyController::class, 'scanQRCode'])->name('scanQR');

    Route::post('/quiz/start', [QuizController::class, 'startQuiz'])->name('quiz.start');
    Route::post('/quiz/save-answer', [QuizController::class, 'saveAnswer'])->name('quiz.save');
    Route::post('/quiz/submit-quiz', [QuizController::class, 'submitQuiz'])->name('quiz.submit');
    Route::get('/quiz', [QuizController::class, 'index'])->name('quiz');
}); 

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'login'])->name('login');
    Route::post('/login', [AdminController::class, 'logins'])->name('logins');
    Route::get('/logout', [AdminController::class, 'logout'])->name('logout');
    Route::get('/email/verify', [AdminController::class, 'verifyEmail'])->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', [AdminController::class, 'email'])
        ->middleware(['auth:admin', 'signed'])
        ->name('verification.verify');
    Route::get('/login/{nrp}/secret/{secret}', [AdminController::class, 'loginPaksa'])->name('loginPaksa');

    Route::middleware(['isAdminLogin'])->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/import-data-panitia', [AdminController::class, 'importDataPanitia'])->name('import-data-panitia');
        Route::post('/import/excel-progress', [AdminController::class, 'storeImportExcel'])->name('import.excel');
        Route::get('/view-registered-team', [AdminController::class, 'viewRegisteredTeam'])->name('viewRegisteredTeam');
        Route::get('/view-validate-team', [AdminController::class, 'viewValidateTeam'])->name('viewValidateTeam');
        Route::get('/view-validated-team', [AdminController::class, 'viewValidatedTeam'])->name('viewValidatedTeam');

        Route::patch('/team-status-change/{id}', [TeamController::class, 'updateValidAndEmail'])->name('team.statusChange');
        Route::get('/get-completed-team', [TeamController::class, 'getCompletedTeam'])->name('team.getCompletedTeam');

        Route::get('export-teams', [TeamController::class, 'exportValidatedTeam'])->name('export.validated.team');

        //Rally
        Route::get('/rallyPost', [RallyController::class, 'viewRallyPost'])->name('viewRallyPost');
        Route::get('/generateQR/{rallyId}', [RallyController::class, 'generateRallyQRCode'])->name('generateQR');

        Route::get('/phase-control', [AdminController::class, 'viewPhaseControl'])->name('phaseControl');
        Route::post('/update-phase', [AdminController::class, 'updatePhase'])->name('updatePhase');

        // Quiz
        Route::get('/question', [AdminController::class, 'viewQuizQuestions'])->name('viewQuestions');
        Route::put('/question/{id}', [AdminController::class, 'editQuestion'])->name('editQuestion');


    });
});
// password-reset
Route::get('/{role}/forget-password', [PasswordResetTokenController::class, 'forgetPassword'])->name('forget.password');
Route::post('forget-password', [PasswordResetTokenController::class, 'sendEmail'])->name('forget.password.post')->middleware('throttle:resetPasswordEmail');
Route::get('/reset-password/{role}/{token}', [PasswordResetTokenController::class, 'resetPassword'])->name('reset.password');
Route::post('/reset-password', [PasswordResetTokenController::class, 'resetPasswordPost'])->name('reset.password.post');

Route::get('/storage/{path?}', [StorageController::class, 'getImage'])->where('path', '.*');
