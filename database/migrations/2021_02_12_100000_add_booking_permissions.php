<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Contracts\Permission;
use Spatie\Permission\PermissionRegistrar;

class AddBookingPermissions extends Migration
{
    public function up()
    {
        if (app()->has(Permission::class)) {
            app(PermissionRegistrar::class)->forgetCachedPermissions();

            foreach ([
                         'view bookings',
                         'create bookings',
                         'update bookings'
                     ] as $name) {
                app(Permission::class)::findOrCreate($name, null);
            };
        }
    }
}