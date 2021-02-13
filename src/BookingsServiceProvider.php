<?php

declare(strict_types=1);

namespace Tipoff\Bookings;

use Tipoff\Discounts\Models\Booking;
use Tipoff\Discounts\Policies\BookingPolicy;
use Tipoff\Support\TipoffPackage;
use Tipoff\Support\TipoffServiceProvider;

class BookingsServiceProvider extends TipoffServiceProvider
{
    public function configureTipoffPackage(TipoffPackage $package): void
    {
        $package
            ->hasPolicies([
                Booking::class => BookingPolicy::class,
            ])
            ->name('bookings')
            ->hasConfigFile();
    }
}
