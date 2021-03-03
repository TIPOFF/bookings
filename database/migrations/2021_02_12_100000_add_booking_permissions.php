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
            'update bookings'
        ];

        $this->createPermissions($permissions);
    }
}
