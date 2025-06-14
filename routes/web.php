<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\DashboardController;
use App\Models\Transaction;

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


Route::get('/', function () {
    return view('welcome');
});



Route::middleware(['auth'])->group(function () {
    Route::resource('categories', CategoryController::class)->except(['show', 'create', 'edit']);
    Route::resource('transactions', TransactionController::class)->except(['show']);

    
});
Route::get('/profile/edit', function () {
    return "Profile edit page - not implemented yet.";
})->name('profile.edit');




require __DIR__.'/auth.php';
