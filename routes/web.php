<?php

use Illuminate\Support\Facades\Route;
use Tipoff\Bookings\Http\Controllers\BookingsController;

Route::middleware(config('tipoff.web.middleware_group'))
    ->prefix(config('tipoff.web.uri_prefix'))
    ->group(function () {
        Route::getLocation('bookings', 'bookings', BookingsController::class);
    });
