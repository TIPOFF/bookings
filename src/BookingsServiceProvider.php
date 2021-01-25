<?php

namespace Tipoff\Bookings;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Tipoff\Bookings\Commands\BookingsCommand;

class BookingsServiceProvider extends PackageServiceProvider
{
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
            ->hasViews()
            ->hasMigration('create_bookings_table')
            ->hasCommand(BookingsCommand::class);
    }
}
