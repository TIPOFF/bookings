<?php

declare(strict_types=1);

use Tipoff\Authorization\Permissions\BasePermissionsMigration;

class AddBookingPermissions extends BasePermissionsMigration
{
    public function up()
    {
        $permissions = [
            'view bookings',
            'create bookings',
            'update bookings',
            'view booking categories',
            'create booking categories',
            'update booking categories',
            'view participants',
            'create participants',
            'update participants',
            'view rates',
            'create rates',
            'update rates',
            'view rate categories',
            'create rate categories',
            'update rate categories',
        ];

        $this->createPermissions($permissions);
    }
}
