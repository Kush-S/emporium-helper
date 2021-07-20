<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ZybooksFileController;

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
});

Route::view('/welcome', 'welcome');
