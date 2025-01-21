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

Route::prefix('outlets')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [OutletController::class, 'index']);
    Route::get('/nearest', [OutletController::class, 'findTheNearest']);
    Route::get('/{outletId}', [OutletController::class, 'show']);
    Route::post('/', [OutletController::class, 'store']);
    Route::put('/{outletId}', [OutletController::class, 'update']);
    Route::delete('/{outletId}', [OutletController::class, 'destroy']);
});
