<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileStorageController;

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


Route::middleware('auth')->group(function(){
    Route::get('/',[FileStorageController::class,'index'])->name('upload.index');
    Route::post('store',[FileStorageController::class,'store'])->name('upload.store');
    Route::delete('delete/{id}',[FileStorageController::class,'destroy'])->name('upload.delete');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('{path}',[FileStorageController::class,'path'])->name('path');
