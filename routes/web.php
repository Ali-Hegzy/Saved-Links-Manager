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

Route::middleware('guest')->group(function (){
    Route::get('/register', [RegisterController::class,'index']);
    Route::post('/register', [RegisterController::class,'create'])->middleware('throttle:login');

    Route::get('/login', [SessionController::class,'index'])->name('login');
    Route::post('/login', [SessionController::class,'create'])->middleware('throttle:login');
});

Route::middleware('auth')->group(function (){
    Route::delete('/logout', [SessionController::class,'destroy']);

    Route::get('/profile',[UserController::class,'index']);

    // Links Resource
    Route::put('links/{link}', [LinkController::class,'update'])
        ->middleware('can:update,link')
        ->name('links.update');
    Route::resource('links', LinkController::class)->except(['update']);

    // Sites Resource
    Route::put('sites/{site}', [SiteController::class,'update'])
        ->middleware('can:update,site')
        ->name('sites.update');
    Route::resource('sites', SiteController::class)->except(['create', 'show', 'update']);

    // Inventories Resource
    Route::put('inventories/{inventory}', [InventoryController::class,'update'])
        ->middleware('can:update,inventory')
        ->name('inventories.update');
    Route::resource('inventories',InventoryController::class)->except(['update']);

    Route::post('/invItems', [inventoryItemController::class, 'store'])->name('inventoryItems.store');
    Route::delete('/invItems', [inventoryItemController::class, 'destroy'])->name('inventoryItems.destroy');
});
