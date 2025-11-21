<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Route::get('/test','App\Http\Controllers\ContentContoller@index');


Route::get('/',[\App\Http\Controllers\UserController::class,'showLogin']);
Route::post('/',[\App\Http\Controllers\UserController::class,'login'])->name('login');

Route::get('/register',[\App\Http\Controllers\UserController::class,'showRegister']);
Route::post('/register',[\App\Http\Controllers\UserController::class,'register']);

Route::middleware('auth')->group(function(){
    Route::get('/profile',[\App\Http\Controllers\UserController::class,'profile'])->name('profile');
    Route::post('/logout',[\App\Http\Controllers\UserController::class,'logout'])->name('user.logout');
});
