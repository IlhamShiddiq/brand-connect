<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\OutletController;
use Illuminate\Support\Facades\Route;

Route::prefix('brands')->group(function () {
    Route::get('/', [BrandController::class, 'list']);
});

Route::prefix('outlets')->group(function () {
    Route::get('/', [OutletController::class, 'list']);
    Route::get('/nearest', [OutletController::class, 'findTheNearest']);
});
