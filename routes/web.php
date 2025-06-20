<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\DashboardController;
use App\Models\Transaction;

// Route to dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Welcome page
Route::get('/', function () {
    return view('welcome');
});

// Transactions and categories pages
Route::middleware(['auth'])->group(function () {
    Route::resource('categories', CategoryController::class)->except(['show', 'create', 'edit']);
    Route::resource('transactions', TransactionController::class)->except(['show']);

    
});

Route::get('/profile/edit', function () {
    return "Profile edit page - not implemented yet.";
})->name('profile.edit');

// Route to send a test email
Route::get('/send-test-email', [DashboardController::class, 'sendTestEmail']);

require __DIR__.'/auth.php';
