<?php

use App\Http\Controllers\CustomerController;

Route::middleware('checkToken:001')->post('/customers', [CustomerController::class, 'store']);
