<?php

use Illuminate\Support\Facades\Route;

use Inertia\Inertia;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\StockMovementController;
use App\Http\Controllers\AiExtractController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\AuthController;

// Public: Invitation routes
Route::get('/invite/{token}', [InvitationController::class, 'show'])->name('invitation.show');
Route::post('/invite/{token}', [InvitationController::class, 'accept'])->name('invitation.accept');

// Public: Magic Link Login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'sendMagicLink'])->middleware('throttle:3,1')->name('login.send');
Route::get('/verify-login/{token}', [AuthController::class, 'verifyLogin'])->name('login.verify');
Route::post('/logout', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Auth only: Inventory & Stock Movement (Super Admin + Admin)
Route::middleware(['auth', 'role:super_admin,admin'])->group(function () {
    Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory');
    Route::post('/inventory', [InventoryController::class, 'store'])->name('inventory.store');
    Route::put('/inventory/{sparePart}', [InventoryController::class, 'update'])->name('inventory.update');
    Route::delete('/inventory/{sparePart}', [InventoryController::class, 'destroy'])->name('inventory.destroy');

    Route::get('/stock-movement', [StockMovementController::class, 'index'])->name('stock-movement');
    Route::post('/stock-movement', [StockMovementController::class, 'store'])->name('stock-movement.store');
});

// Super Admin only: Management routes
Route::middleware(['auth', 'role:super_admin'])->group(function () {
    Route::get('/management/category', [CategoryController::class, 'index'])->name('category');
    Route::post('/management/category', [CategoryController::class, 'store'])->name('category.store');
    Route::put('/management/category/{category}', [CategoryController::class, 'update'])->name('category.update');
    Route::delete('/management/category/{category}', [CategoryController::class, 'destroy'])->name('category.destroy');

    Route::get('/management/users', [UserController::class, 'index'])->name('users');
    Route::post('/management/users/invite', [UserController::class, 'invite'])->name('users.invite');
    Route::put('/management/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/management/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::patch('/management/users/{user}/toggle-active', [UserController::class, 'toggleActive'])->name('users.toggle-active');
    Route::delete('/management/users/invitations/{invitation}', [UserController::class, 'cancelInvitation'])->name('users.cancel-invitation');

    Route::get('/management/locations', [LocationController::class, 'index'])->name('locations');
    Route::post('/management/locations', [LocationController::class, 'store'])->name('locations.store');
    Route::put('/management/locations/{location}', [LocationController::class, 'update'])->name('locations.update');
    Route::delete('/management/locations/{location}', [LocationController::class, 'destroy'])->name('locations.destroy');
});

// Export Routes
Route::get('/export/{format}', [ExportController::class, 'export'])->name('export');

// API Routes
Route::get('/api/stock-movement/{transaction_id}', [StockMovementController::class, 'show']);
Route::post('/api/ai/extract-item', [AiExtractController::class, 'extract']);
Route::get('/api/notifications', [NotificationController::class, 'index']);
Route::put('/api/notifications/{notification}/read', [NotificationController::class, 'markAsRead']);
Route::put('/api/notifications/read-all', [NotificationController::class, 'markAllRead']);