<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;

Route::middleware('checkToken:001')->post('/customers', [CustomerController::class, 'store']);
Route::middleware('checkToken:002')->get('/customers/{id}', [CustomerController::class, 'show']);
Route::middleware('checkToken:003')->get('/customers', [CustomerController::class, 'index']);
Route::middleware('checkToken:006')->post('/orders', [OrderController::class, 'store']);

