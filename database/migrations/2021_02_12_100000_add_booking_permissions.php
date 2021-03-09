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
            'view participants' => ['Owner', 'Staff'],
            'view slots' => ['Owner', 'Staff'],
            'create slots' => ['Owner'],
            'update slots' => ['Owner'],
        ];

        $this->createPermissions($permissions);
    }
}
