<?php

declare(strict_types=1);

namespace Tipoff\Bookings;

use Tipoff\Bookings\Models\Booking;
use Tipoff\Bookings\Models\BookingCategory;
use Tipoff\Bookings\Models\Participant;
use Tipoff\Bookings\Models\Rate;
use Tipoff\Bookings\Models\RateCategory;
use Tipoff\Bookings\Policies\BookingCategoryPolicy;
use Tipoff\Bookings\Policies\BookingPolicy;
use Tipoff\Bookings\Policies\ParticipantPolicy;
use Tipoff\Bookings\Policies\RateCategoryPolicy;
use Tipoff\Bookings\Policies\RatePolicy;
use Tipoff\Support\TipoffPackage;
use Tipoff\Support\TipoffServiceProvider;

class BookingsServiceProvider extends TipoffServiceProvider
{
    public function configureTipoffPackage(TipoffPackage $package): void
    {
        $package
            ->hasPolicies([
                Booking::class => BookingPolicy::class,
                BookingCategory::class => BookingCategoryPolicy::class,
                Participant::class => ParticipantPolicy::class,
                Rate::class => RatePolicy::class,
                RateCategory::class => RateCategoryPolicy::class
            ])
            ->hasNovaResources([
                \Tipoff\Bookings\Nova\Booking::class,
                \Tipoff\Bookings\Nova\Participant::class,
                \Tipoff\Bookings\Nova\Rate::class,
            ])
            ->name('bookings')
            ->hasConfigFile();
    }
}
