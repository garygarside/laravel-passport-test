<?php

use Illuminate\Support\Facades\Route;

Route::post('/register', [App\Http\Controllers\API\AuthController::class, 'register'])->name('api.register');
Route::post('/token', [App\Http\Controllers\API\AuthController::class, 'token'])->name('api.token');

Route::middleware('auth:api')->group(function () {
    Route::get('/accounts', [App\Http\Controllers\API\AccountController::class, 'index'])->name('api.accounts.index');
    Route::post('/accounts', [App\Http\Controllers\API\AccountController::class, 'create'])->name('api.accounts.create');
    Route::get('/accounts/{account}', [App\Http\Controllers\API\AccountController::class, 'show'])->name('api.accounts.show');

    Route::get('/accounts/{account}/transactions', [App\Http\Controllers\API\TransactionController::class, 'index'])->name('api.transactions.index');
    Route::post('/accounts/{account}/transactions', [App\Http\Controllers\API\TransactionController::class, 'create'])->name('api.transactions.create');
});
