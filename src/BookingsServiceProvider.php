<?php

declare(strict_types=1);

namespace Tipoff\Bookings;

use Illuminate\Support\Facades\Gate;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Tipoff\Bookings\Models\Booking;
use Tipoff\Bookings\Policies\BookingPolicy;

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
            ->name('bookings')
            ->hasConfigFile()
            ->hasViews();
    }

    public function registeringPackage()
    {
        Gate::policy(Booking::class, BookingPolicy::class);
    }
}
