<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ZybooksFileController;
use App\Http\Controllers\AnalysisController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\SettingsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('home');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';


// Route::get('/', [ZybooksFileController::class, 'index']);

Route::middleware(['auth', 'whitelisted'])->prefix('classroom')->group(function () {
    Route::get('/list', [ClassroomController::class, 'index'])->name('classroom_index');
    Route::get('/create', [ClassroomController::class, 'create'])->name('classroom_create');
    Route::post('/save', [ClassroomController::class, 'saveClassroom'])->name('classroom_save');
    Route::get('/search', [ClassroomController::class, 'searchIndex'])->name('classroom_search_index');
    Route::middleware(['access'])->prefix('{id}')->group(function($id){
      Route::group(['prefix' => '/analysis'], function(){
        Route::get('/', [AnalysisController::class, 'index'])->name('analysis_index');
        Route::get('/students', [AnalysisController::class, 'student_list'])->name('analysis_students_list');
        Route::get('/name', [AnalysisController::class, 'student_info'])->name('analysis_student_info');
      });
      Route::group(['prefix' => '/files'], function(){
        Route::get('/', [ZybooksFileController::class, 'index'])->name('files_index');
        Route::post('/upload', [ZybooksFileController::class, 'uploadFile'])->name('files_upload');
        Route::get('/download/{file}', [ZybooksFileController::class, 'downloadFile'])->name('files_download');
        Route::get('/delete/{file}', [ZybooksFileController::class, 'deleteFile'])->name('files_delete');
      });
      Route::group(['prefix' => '/settings'], function(){
        Route::get('/', [SettingsController::class, 'index'])->name('settings_index');
        Route::get('/add_instructor', [SettingsController::class, 'addInstructor'])->name('settings_add_instructor');
        Route::post('/add_instructor_submit', [SettingsController::class, 'addMember'])->name('settings_add_instructor_submit');
      });
    });
    // Route::get('/{id}', [ClassroomController::class, 'enterClassroom'])->name('classroom_enter');
    // Route::get('/{id}/statistics', [ClassroomController::class, 'searchIndex'])->name('classroom_statistics_index');
});

// Route::prefix('files')->group(function () {
//   Route::get('/', [ZybooksFileController::class, 'index'])->name('files_index');
//   Route::post('/upload', [ZybooksFileController::class, 'uploadFile'])->name('files_upload');
//   Route::get('/download/{file}', [ZybooksFileController::class, 'downloadFile'])->name('files_download');
//   Route::get('/delete/{file}', [ZybooksFileController::class, 'deleteFile'])->name('files_delete');
// });

// Route::prefix('statistics')->group(function () {
//   Route::get('/', [StatisticsController::class, 'index'])->name('statistics_index');
//   Route::get('/calculate_risk', [StatisticsController::class, 'recalculateRisk'])->name('statistics_calculate');
// });

// Route::prefix('settings')->group(function () {
//   Route::view('/', 'settings')->name('settings_index');
// });

// Route::view('/welcome', 'welcome');

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ConfirmPasswordController;
use App\Http\Controllers\Auth\VerificationController;

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class,'login']);
Route::post('logout',  [LoginController::class,'logout'])->name('logout');

// Registration Routes...
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register'])->middleware('whitelisted.register');

// Password Reset Routes...
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ForgotPasswordController::class, 'reset'])->name('password.update');

// Confirm Password
Route::get('password/confirm', [ConfirmPasswordController::class, 'showConfirmForm'])->name('password.confirm');
Route::post('password/confirm', [ConfirmPasswordController::class, 'confirm']);

// Email Verification Routes...
Route::get('email/verify', [VerificationController::class, 'show'])->name('verification.notice');
Route::get('email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');
Route::get('email/resend',  [VerificationController::class, 'resend'])->name('verification.resend');
