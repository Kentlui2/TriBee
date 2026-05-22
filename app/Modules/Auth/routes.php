<?php

use App\Http\Middleware\Authenticate;
use App\Http\Middleware\IsAdmin;
use App\Modules\Auth\Controllers\AuthController;
use App\Modules\Auth\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// ── Guest Routes ─────────────────────────────
Route::middleware('guest')->group(function () {
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

// ── Protected (Authenticated) Routes ─────────
Route::middleware(['auth'])->group(function () {
    
    // Profile views
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', fn() => view('profile.dashboard'))->name('dashboard');
        Route::get('/edit', fn() => view('profile.edit'))->name('edit');
        Route::get('/addresses', fn() => view('profile.addresses'))->name('addresses');
    });

    // Profile API
    Route::prefix('api/profile')->name('api.profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'show'])->name('show');
        Route::put('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
        Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password');
        Route::get('/addresses', [ProfileController::class, 'addresses'])->name('addresses');
        Route::post('/addresses', [ProfileController::class, 'storeAddress'])->name('addresses.store');
        Route::delete('/addresses/{id}', [ProfileController::class, 'destroyAddress'])->name('addresses.destroy');
    });

});

// ── Admin-Only Routes ────────────────────────
Route::middleware(['auth', 'isAdmin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', fn() => view('admin.dashboard'))->name('dashboard');
        Route::get('/users', fn() => view('admin.users'))->name('users');
    });