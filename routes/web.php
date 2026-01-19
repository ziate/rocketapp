<?php

use App\Http\Controllers\AreaController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeliveryDriverController;
use App\Http\Controllers\GovernorateController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderTypeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('governorates', GovernorateController::class);
Route::resource('areas', AreaController::class);
Route::resource('customers', CustomerController::class);
Route::resource('delivery-drivers', DeliveryDriverController::class);
Route::resource('order-types', OrderTypeController::class);
Route::resource('orders', OrderController::class);
