<?php

use App\Http\Controllers\Income\IncomeController;
use App\Http\Controllers\Expense\ExpenseController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [LoginController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('incomes', IncomeController::class);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('expenses', ExpenseController::class);
});

