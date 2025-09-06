<?php

use App\Http\Controllers\CustomerController;

Route::middleware('checkToken:001')->post('/customers', [CustomerController::class, 'store']);
Route::middleware('checkToken:002')->get('/customers/{id}', [CustomerController::class, 'show']);
