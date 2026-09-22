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
Route::post('/register', [RegisterController::class,'create'])->middleware(['guest', 'throttle:login']);

Route::get('/login', [SessionController::class,'index'])->name('login')->middleware('guest');
Route::post('/login', [SessionController::class,'create'])->middleware(['guest', 'throttle:login']);

Route::delete('/logout', [SessionController::class,'destroy'])->middleware('auth');

Route::middleware('auth')->group(function (){
    Route::put('links/{link}', [LinkController::class,'update'])
        ->middleware('can:update,link')
        ->name('links.update');

    Route::resource('links', LinkController::class)->except(['update']);
});

Route::get('/profile',[UserController::class,'index'])->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::put('sites/{site}', [SiteController::class,'update'])
        ->middleware('can:update,site')
        ->name('sites.update');

    Route::resource('sites', SiteController::class)->except(['create', 'show', 'update']);
});

Route::middleware('auth')->group(function (){
    Route::put('inventories/{inventory}', [InventoryController::class,'update'])
        ->middleware('can:update,inventory')
        ->name('inventories.update');

    Route::resource('inventories',InventoryController::class)->except(['update']);
});

Route::post('/invItems', [inventoryItemController::class, 'store'])->middleware('auth')->name('inventoryItems.store');
Route::delete('/invItems', [inventoryItemController::class, 'destroy'])->middleware('auth')->name('inventoryItems.destroy');
