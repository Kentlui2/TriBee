<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Modules\Products\Controllers\ProductController;
use App\Modules\Products\Controllers\CategoryController;
use App\Modules\Products\Controllers\CatalogController;

// TASK ASSIGNMENT: SYSTEM INTERCEPTION & GATEWAY LAYERS (Member 1 - Billiones)
Route::match(['get', 'post'], '/dashboard', [ProductController::class, 'index'])->name('dashboard');

// 1. PUBLIC STOREFRONT ROUTES (Accessible to all logged-in users)
//CORE TASK: MEMBER 1 (Billiones - Frontend Storefront Integration)
Route::prefix('dashboard')->name('products.')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('index');
    Route::get('/search', [ProductController::class, 'search'])->name('search');
    Route::get('/category/{categoryId}', [ProductController::class, 'byCategory'])->name('by-category');
    Route::get('/{id}', [ProductController::class, 'show'])->name('show');
});

Route::prefix('categories')->name('categories.')->group(function () {
    Route::get('/', [CategoryController::class, 'index'])->name('index');
    Route::get('/{id}', [CategoryController::class, 'show'])->name('show');
});

// 2. PROTECTED ADMIN PANEL CRUD (Enforced by 'isAdmin' middleware)
// CORE TASK: MEMBER 4 (Francis - Admin Inventory API Management)
Route::middleware(['auth', 'isAdmin'])->group(function () {

    // Admin Dashboard Product Management
    Route::prefix('admin/products')->name('admin.products.')->group(function () {
        Route::get('/', [ProductController::class, 'adminDashboard'])->name('index');
        Route::get('/create', [ProductController::class, 'create'])->name('create');
        Route::get('/{id}/edit', [ProductController::class, 'edit'])->name('edit');
        Route::post('/store', [ProductController::class, 'store'])->name('store');
        Route::put('/{id}', [ProductController::class, 'update'])->name('update');
        Route::patch('/{id}', [ProductController::class, 'update'])->name('patch');
        Route::delete('/{id}', [ProductController::class, 'destroy'])->name('destroy');
    });

    // Admin Dashboard Category Management
    Route::prefix('admin/categories')->name('admin.categories.')->group(function () {
        Route::post('/', [CategoryController::class, 'store'])->name('store');
        Route::put('/{id}', [CategoryController::class, 'update'])->name('update');
        Route::patch('/{id}', [CategoryController::class, 'update'])->name('patch');
        Route::delete('/{id}', [CategoryController::class, 'destroy'])->name('destroy');
        Route::get('/{id}/edit', [CategoryController::class, 'edit'])->name('edit');
    });
});