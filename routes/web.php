<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\SessionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->middleware('auth');

Route::get('/register', [RegisterController::class,'index'])->middleware('guest');
Route::post('/register', [RegisterController::class,'create'])->middleware('guest');

Route::get('/login', [SessionController::class,'index'])->name('login')->middleware('guest');
Route::post('/login', [SessionController::class,'create'])->middleware('guest');
