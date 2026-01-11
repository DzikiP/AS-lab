<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserManagementController;
use Illuminate\Support\Facades\Route;

// Strona główna
Route::get('/', fn() => view('welcome'));

// Gość
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Zalogowany
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Produkty
    Route::middleware(['auth', 'role:worker'])->group(function () {
        Route::resource('products', ProductController::class);
    });
    // Zamówienia - klient
    Route::middleware(['auth', 'role:client'])->group(function () {
        Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
        Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
        Route::get('/orders/my', [OrderController::class, 'myOrders'])->name('orders.my');
    });

    // Zamówienia - worker
    Route::middleware(['auth', 'role:worker'])->group(function () {
        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}/edit', [OrderController::class, 'edit'])->name('orders.edit');
        Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
    });

    // Zarządzanie użytkownikami - admin
    Route::middleware('role:admin')->group(function () {
        Route::resource('users', UserManagementController::class);
    });
});
