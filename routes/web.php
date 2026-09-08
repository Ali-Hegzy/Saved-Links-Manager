<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\SessionController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\inventoryItemController;
use App\Http\Controllers\LinkController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/register', [RegisterController::class,'index'])->middleware('guest');
Route::post('/register', [RegisterController::class,'create'])->middleware('guest');

Route::get('/login', [SessionController::class,'index'])->name('login')->middleware('guest');
Route::post('/login', [SessionController::class,'create'])->middleware('guest');

Route::delete('/logout', [SessionController::class,'destroy'])->middleware('auth');

Route::middleware('auth')->group(function (){
    Route::resource('links', LinkController::class);
});

Route::get('/profile',[UserController::class,'index'])->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::resource('sites', SiteController::class);
});

Route::middleware('auth')->group(function (){
    Route::resource('inventories',InventoryController::class);
});

Route::post('/invItems', [inventoryItemController::class, 'store'])->name('inventoryItems.store');
Route::delete('/invItems', [inventoryItemController::class, 'destroy'])->name('inventoryItems.destroy');
