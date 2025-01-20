<?php

use App\Http\Controllers\BrandController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('brands')->group(function () {
    Route::get('/', [BrandController::class, 'index']);
    Route::get('/{brandId}', [BrandController::class, 'show']);
    Route::post('/', [BrandController::class, 'store']);
    Route::put('/{brandId}', [BrandController::class, 'update']);
    Route::delete('/{brandId}', [BrandController::class, 'destroy']);
});
