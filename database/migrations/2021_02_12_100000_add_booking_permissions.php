<?php

declare(strict_types=1);

use Tipoff\Authorization\Permissions\BasePermissionsMigration;

class AddBookingPermissions extends BasePermissionsMigration
{
    public function up()
    {
        $permissions = [
            'view bookings' => ['Owner', 'Staff'],
            'create bookings' => ['Owner'],
            'update bookings' => ['Owner'],
            'view booking categories' => ['Owner', 'Staff'],
            'create booking categories' => ['Owner'],
            'update booking categories' => ['Owner'],
            'view participants' => ['Owner', 'Staff'],
            'view slots' => ['Owner', 'Staff'],
            'create slots' => ['Owner'],
            'update slots' => ['Owner'],
            'view rates' => ['Owner', 'Staff'],
            'create rates' => ['Owner'],
            'update rates' => ['Owner'],
            'view rate categories' => ['Owner', 'Staff'],
            'create rate categories' => ['Owner'],
            'update rate categories' => ['Owner'],
        ];

        $this->createPermissions($permissions);
    }
}
