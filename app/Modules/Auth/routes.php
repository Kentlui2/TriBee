<?php

// G1 - Member 6: Module routes for authenticated and admin routes
// G1 - Member 2: Profile web routes added

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Modules\Auth\Controllers\ProfileWebController;

/*
|--------------------------------------------------------------------------
| Group 1 — Auth Module Routes
|--------------------------------------------------------------------------
*/

// ── Protected (Authenticated) Routes ─────────────────
Route::middleware(['auth'])->group(function () {

    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileWebController::class, 'show'])->name('dashboard');
        Route::get('/edit', [ProfileWebController::class, 'edit'])->name('edit');
        Route::get('/addresses', [ProfileWebController::class, 'addresses'])->name('addresses');
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