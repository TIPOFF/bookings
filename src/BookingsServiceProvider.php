<?php

declare(strict_types=1);

namespace Tipoff\Bookings;

use Tipoff\Bookings\Models\Booking;
use Tipoff\Bookings\Models\BookingCategory;
use Tipoff\Bookings\Models\BookingSlot;
use Tipoff\Bookings\Models\Participant;
use Tipoff\Bookings\Models\Rate;
use Tipoff\Bookings\Models\RateCategory;
use Tipoff\Bookings\Policies\BookingCategoryPolicy;
use Tipoff\Bookings\Policies\BookingPolicy;
use Tipoff\Bookings\Policies\ParticipantPolicy;
use Tipoff\Bookings\Policies\RateCategoryPolicy;
use Tipoff\Bookings\Policies\RatePolicy;
use Tipoff\Support\Contracts\Booking\BookingCategoryInterface;
use Tipoff\Support\Contracts\Booking\BookingInterface;
use Tipoff\Support\Contracts\Booking\BookingParticipantInterface;
use Tipoff\Support\Contracts\Booking\BookingRateCategoryInterface;
use Tipoff\Support\Contracts\Booking\BookingRateInterface;
use Tipoff\Support\Contracts\Booking\BookingSlotInterface;
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
                RateCategory::class => RateCategoryPolicy::class,
            ])
            ->hasNovaResources([
                \Tipoff\Bookings\Nova\Booking::class,
                \Tipoff\Bookings\Nova\Participant::class,
                \Tipoff\Bookings\Nova\Rate::class,
            ])
            ->hasModelInterfaces([
                BookingInterface::class => Booking::class,
                BookingCategoryInterface::class => BookingCategory::class,
                BookingSlotInterface::class => BookingSlot::class,
                BookingParticipantInterface::class => Participant::class,
                BookingRateInterface::class => Rate::class,
                BookingRateCategoryInterface::class => RateCategory::class,
            ])
            ->hasWebRoute('web')
            ->name('bookings')
            ->hasViews()
            ->hasConfigFile();
    }
}
