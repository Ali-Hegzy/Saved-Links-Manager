<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\SessionController;
use App\Http\Controllers\LinkController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/register', [RegisterController::class,'index'])->middleware('guest');
Route::post('/register', [RegisterController::class,'create'])->middleware('guest');

Route::get('/login', [SessionController::class,'index'])->name('login')->middleware('guest');
Route::post('/login', [SessionController::class,'create'])->middleware('guest');

Route::delete('/logout', [SessionController::class,'destroy'])->middleware('auth');

Route::get('/links', [LinkController::class,'index'])->middleware('auth');
Route::get('/links/create', [LinkController::class,'create'])->middleware('auth');
Route::post('/links/create', [LinkController::class,'store'])->middleware('auth');
