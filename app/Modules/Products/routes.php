<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Modules\Products\Controllers\ProductController;
use App\Modules\Products\Controllers\CategoryController;

// Safely probe for Group 1's authentication guards using string paths
$authMiddleware = class_exists('App\Http\Middleware\Authenticate') 
    ? 'App\Http\Middleware\Authenticate' 
    : 'web'; 

$adminMiddleware = class_exists('App\Http\Middleware\IsAdmin') 
    ? 'App\Http\Middleware\IsAdmin' 
    : 'web';

// =========================================================================
// 1. PUBLIC STOREFRONT ROUTES (Accessible to guests)
// =========================================================================
Route::prefix('products')->name('products.')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('index');
    Route::get('/search', [ProductController::class, 'search'])->name('search');
    Route::get('/category/{categoryId}', [ProductController::class, 'byCategory'])->name('by-category');
    
    // Wildcard variable params must ALWAYS stay at the bottom of the prefix block
    Route::get('/{id}', [ProductController::class, 'show'])->name('show');
});

Route::prefix('categories')->name('categories.')->group(function () {
    Route::get('/', [CategoryController::class, 'index'])->name('index');
    Route::get('/{id}', [CategoryController::class, 'show'])->name('show');
});

// =========================================================================
// 2. PROTECTED ADMIN PANEL CRUD (Group 1 Authenticated Accounts Only)
// =========================================================================
Route::middleware([$authMiddleware, $adminMiddleware])->group(function () {

    // Admin Product Actions (Dead 'create' view path removed)
    Route::prefix('products')->name('products.')->group(function () {
        Route::post('/', [ProductController::class, 'store'])->name('store');
        Route::put('/{id}', [ProductController::class, 'update'])->name('update');
        Route::patch('/{id}', [ProductController::class, 'update'])->name('patch');
        Route::delete('/{id}', [ProductController::class, 'destroy'])->name('destroy');
    });

    // Admin Category Actions
    Route::prefix('categories')->name('categories.')->group(function () {
        Route::post('/', [CategoryController::class, 'store'])->name('store');
        Route::put('/{id}', [CategoryController::class, 'update'])->name('update');
        Route::patch('/{id}', [CategoryController::class, 'update'])->name('patch');
        Route::delete('/{id}', [CategoryController::class, 'destroy'])->name('destroy');
    });
});