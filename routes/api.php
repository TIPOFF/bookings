<?php

use Illuminate\Support\Facades\Route;

Route::post('/{location:slug}/checkout', [Tipoff\Booking\Http\Controllers\CheckoutController::class, 'store']);
Route::get('/locations/{location:slug}', [Tipoff\Booking\Http\Controllers\LocationsController::class, 'show']);
Route::post('/{location:slug}/contact-details', [Tipoff\Booking\Http\Controllers\ContactDetailsController::class, 'store']);
Route::post('/{user:id}/voucher-applications', [Tipoff\Booking\Http\Controllers\VoucherApplicationsController::class, 'store']);
Route::post('/{user:id}/discount-applications', [Tipoff\Booking\Http\Controllers\DiscountApplicationsController::class, 'store']);
Route::get('/users/{user:id}/cart', [Tipoff\Booking\Http\Controllers\CartsController::class, 'show']);
Route::post('/users/{user:id}/cart-items', [Tipoff\Booking\Http\Controllers\CartItemsController::class, 'store']);
Route::delete('/cart-items/{cartItem:id}', [Tipoff\Booking\Http\Controllers\CartItemsController::class, 'destroy']);
