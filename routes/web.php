<?php

use App\Http\Controllers\API\LoanController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/*
 *
 */
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
 * All the routes for the loans api resources
 * Uses the auth middleware, which required authentication to do most of the actions
 */
Route::middleware('auth')->group(function () {
    Route::name('loans.')->group(function () {
        Route::get('/loans', [LoanController::class, 'index'])->name('index');
        Route::post('/loans', [LoanController::class, 'store'])->name('store');
        Route::get('/loans/{loan}', [LoanController::class, 'show'])->name('show');
        Route::put('/loans/{loan}', [LoanController::class, 'update'])->name('update');
        Route::delete('/loans/{loan}', [LoanController::class, 'destroy'])->name('destroy');
    });
});

require __DIR__.'/auth.php';


