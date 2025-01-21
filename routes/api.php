<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\OutletController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
});

Route::prefix('brands')->group(function () {
    Route::get('/', [BrandController::class, 'list']);
});

Route::prefix('outlets')->group(function () {
    Route::get('/', [OutletController::class, 'list']);
});
