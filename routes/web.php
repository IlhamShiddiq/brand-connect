<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\OutletController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('brands')->group(function () {
        Route::get('/', [BrandController::class, 'index'])->name('brand.index');
        Route::get('/create', [BrandController::class, 'create'])->name('brand.create');
        Route::get('/edit/{id}', [BrandController::class, 'edit'])->name('brand.edit');
        Route::post('/', [BrandController::class, 'store'])->name('brand.store');
        Route::put('/{id}', [BrandController::class, 'update'])->name('brand.update');
        Route::delete('/', [BrandController::class, 'destroy'])->name('brand.destroy');
    });

    Route::prefix('outlets')->group(function () {
        Route::get('/', [OutletController::class, 'index'])->name('outlet.index');
        Route::get('/create', [OutletController::class, 'create'])->name('outlet.create');
        Route::get('/edit/{id}', [OutletController::class, 'edit'])->name('outlet.edit');
        Route::post('/', [OutletController::class, 'store'])->name('outlet.store');
        Route::put('/{id}', [OutletController::class, 'update'])->name('outlet.update');
        Route::delete('/', [OutletController::class, 'destroy'])->name('outlet.destroy');
    });
});

require __DIR__.'/auth.php';
