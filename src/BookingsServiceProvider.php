<?php

namespace Tipoff\Bookings;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Tipoff\Discounts\Models\Booking;
use Tipoff\Support\TipoffPackage;
use Tipoff\Support\TipoffServiceProvider;

class BookingsServiceProvider extends PackageServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        parent::boot();
    }

    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->hasModelInterfaces([
                BookingInterface::class => Booking::class,
            ])
            ->name('bookings')
            ->hasConfigFile()
            ->hasViews();
    }
}
