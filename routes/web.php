<?php

use Illuminate\Support\Facades\Route;

use Inertia\Inertia;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\StockMovementController;
use App\Http\Controllers\AiExtractController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory');
Route::post('/inventory', [InventoryController::class, 'store'])->name('inventory.store');
Route::put('/inventory/{sparePart}', [InventoryController::class, 'update'])->name('inventory.update');
Route::delete('/inventory/{sparePart}', [InventoryController::class, 'destroy'])->name('inventory.destroy');
Route::get('/management/category', [CategoryController::class, 'index'])->name('category');
Route::post('/management/category', [CategoryController::class, 'store'])->name('category.store');
Route::put('/management/category/{category}', [CategoryController::class, 'update'])->name('category.update');
Route::delete('/management/category/{category}', [CategoryController::class, 'destroy'])->name('category.destroy');
Route::get('/management/users', function () {
    return Inertia::render('Management/Users/Index');
})->name('users');
Route::get('/management/locations', [LocationController::class, 'index'])->name('locations');
Route::post('/management/locations', [LocationController::class, 'store'])->name('locations.store');
Route::put('/management/locations/{location}', [LocationController::class, 'update'])->name('locations.update');
Route::delete('/management/locations/{location}', [LocationController::class, 'destroy'])->name('locations.destroy');
Route::get('/stock-movement', [StockMovementController::class, 'index'])->name('stock-movement');
Route::post('/stock-movement', [StockMovementController::class, 'store'])->name('stock-movement.store');

// API Routes
Route::get('/api/stock-movement/{transaction_id}', [StockMovementController::class, 'show']);
Route::post('/api/ai/extract-item', [AiExtractController::class, 'extract']);
