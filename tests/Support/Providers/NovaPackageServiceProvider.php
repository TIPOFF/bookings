<?php

declare(strict_types=1);

namespace Tipoff\Bookings\Tests\Support\Providers;

use Tipoff\Bookings\Nova\Booking;
use Tipoff\Bookings\Nova\BookingCategory;
use Tipoff\Bookings\Nova\Participant;
use Tipoff\Bookings\Nova\Rate;
use Tipoff\Bookings\Nova\RateCategory;
use Tipoff\TestSupport\Providers\BaseNovaPackageServiceProvider;

class NovaPackageServiceProvider extends BaseNovaPackageServiceProvider
{
    public static array $packageResources = [
        Booking::class,
        BookingCategory::class,
        Participant::class,
        Rate::class,
        RateCategory::class,
    ];
}
