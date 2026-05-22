<?php

/**
 * G1 - Member 6: Justine (Capapas)
 * Module routes - authenticated, admin, and API routes
 */

use App\Modules\Auth\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Group 1 — Auth Module Routes
|--------------------------------------------------------------------------
*/

// ── Protected (Authenticated) Routes ─────────────────
Route::middleware(['auth'])->group(function () {
    
    // Profile views 
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', fn() => view('profile.dashboard'))->name('dashboard');
        Route::get('/edit', fn() => view('profile.edit'))->name('edit');
        Route::get('/addresses', fn() => view('profile.addresses'))->name('addresses');
    });

    // Profile API (G1 - Member 4: Shaina)
    Route::prefix('api/profile')->name('api.profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'show'])->name('show');
        Route::put('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
        Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password');
        Route::get('/addresses', [ProfileController::class, 'addresses'])->name('addresses');
        Route::post('/addresses', [ProfileController::class, 'storeAddress'])->name('addresses.store');
        Route::delete('/addresses/{id}', [ProfileController::class, 'destroyAddress'])->name('addresses.destroy');
    });

    // Logout (G1 - Member 6: Justine)
    Route::post('/logout', function () {
        Auth::logout();
        return redirect('/');
    })->name('logout');
});

// ── Admin-Only Routes (G1 - Member 6: Justine) ──────
Route::middleware(['auth', 'isAdmin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', fn() => view('admin.dashboard'))->name('dashboard');
        Route::get('/users', fn() => view('admin.users'))->name('users');
    });