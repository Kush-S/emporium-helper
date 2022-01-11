<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ZybooksFileController;
use App\Http\Controllers\StatisticsController;

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

Route::get('/', [ZybooksFileController::class, 'index']);

Route::prefix('files')->group(function () {
  Route::get('/', [ZybooksFileController::class, 'index'])->name('files_index');
  Route::post('/upload', [ZybooksFileController::class, 'uploadFile'])->name('files_upload');
  Route::get('/download/{file}', [ZybooksFileController::class, 'downloadFile'])->name('files_download');
  Route::get('/delete/{file}', [ZybooksFileController::class, 'deleteFile'])->name('files_delete');
});

Route::prefix('statistics')->group(function () {
  Route::get('/', [StatisticsController::class, 'index'])->name('statistics_index');
  Route::get('/calculate_risk', [StatisticsController::class, 'recalculateRisk'])->name('statistics_calculate');
});

Route::prefix('settings')->group(function () {
  Route::view('/', 'settings')->name('settings_index');
});

Route::view('/welcome', 'welcome');
