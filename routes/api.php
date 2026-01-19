<?php

use App\Http\Controllers\Api\CustomerAreaController;
use Illuminate\Support\Facades\Route;

Route::get('/customers/{customer}/areas', [CustomerAreaController::class, 'index']);
