<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/



Route::get('/',[\App\Http\Controllers\UserController::class,'showLogin']);
Route::post('/',[\App\Http\Controllers\UserController::class,'login'])->name('login');

Route::get('/register',[\App\Http\Controllers\UserController::class,'showRegister'])->name('userRegistForm');
Route::post('/register',[\App\Http\Controllers\UserController::class,'register']);
Route::get('/notFound',[\App\Http\Controllers\UserController::class,'notFound'])->name('notFound');

Route::middleware('auth')->group(function(){
    Route::get('/profile',[\App\Http\Controllers\UserController::class,'profile'])->name('profile');
    Route::get('/logout',[\App\Http\Controllers\UserController::class,'logout'])->name('user.logout');
    Route::get('/index',[App\Http\Controllers\ContentController::class,'index'])->name('index');
    Route::get('/registform',[App\Http\Controllers\ContentController::class,'showContentRegistForm'])->name('showContentRegistForm');
    Route::post('/registform',[App\Http\Controllers\ContentController::class,'registContent'])->name('ContentRegist');
    Route::get('/content/{id}',[App\Http\Controllers\ContentController::class,'detailContent'])->name('detailContent');
    Route::get('/update/{id}',[App\Http\Controllers\ContentController::class,'updateForm'])->name('updateForm');
    Route::patch('/update/{id}',[App\Http\Controllers\ContentController::class,'updateContent'])->name('updateContent');
    Route::delete('/delete/{id}',[App\Http\Controllers\ContentController::class,'DeleteContent'])->name('deleteContent');
});
