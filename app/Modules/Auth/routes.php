<?php

// G1 - Member 6: Module routes for authenticated and admin routes CAPAPAS

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Group 1 — Auth Module Routes
|--------------------------------------------------------------------------
*/

// ── Protected (Authenticated) Routes ─────────────────
Route::middleware(['auth'])->group(function () {
    
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', fn() => view('profile.dashboard'))->name('dashboard');
        Route::get('/edit', fn() => view('profile.edit'))->name('edit');
        Route::get('/addresses', fn() => view('profile.addresses'))->name('addresses');
    });

    Route::post('/logout', function () {
        Auth::logout();
        return redirect('/');
    })->name('logout');
});

// ── Admin-Only Routes ────────────────────────────────
Route::middleware(['auth', 'isAdmin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', fn() => view('admin.dashboard'))->name('dashboard');
        Route::get('/users', fn() => view('admin.users'))->name('users');
    });