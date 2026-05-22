<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Load default Laravel auth routes
require __DIR__.'/auth.php';

// Load module routes — one per group
require base_path('app/Modules/Auth/routes.php');
require base_path('app/Modules/Products/routes.php');   
// require base_path('app/Modules/Cart/routes.php');       // G3
// require base_path('app/Modules/Orders/routes.php');     // G4
// require base_path('app/Modules/Payment/routes.php');    // G5