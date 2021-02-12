<?php

namespace Tipoff\Bookings;

use Tipoff\Bookings\Models\Booking;
use Tipoff\Support\TipoffPackage;
use Tipoff\Support\TipoffServiceProvider;

class BookingsServiceProvider extends TipoffServiceProvider
{
    public function configureTipoffPackage(TipoffPackage $package): void
    {
        $package
            ->name('bookings')
            ->hasConfigFile()
            ->hasViews();
    }
}
