<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\OutletController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
});

Route::prefix('brands')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [BrandController::class, 'index']);
    Route::get('/{brandId}', [BrandController::class, 'show']);
    Route::post('/', [BrandController::class, 'store']);
    Route::put('/{brandId}', [BrandController::class, 'update']);
    Route::delete('/{brandId}', [BrandController::class, 'destroy']);
});

Route::prefix('outlets')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [OutletController::class, 'index']);
    Route::get('/nearest', [OutletController::class, 'findTheNearest']);
    Route::get('/{outletId}', [OutletController::class, 'show']);
    Route::post('/', [OutletController::class, 'store']);
    Route::put('/{outletId}', [OutletController::class, 'update']);
    Route::delete('/{outletId}', [OutletController::class, 'destroy']);
});
