<?php

declare(strict_types=1);

use Tipoff\Authorization\Permissions\BasePermissionsMigration;

class AddBookingPermissions extends BasePermissionsMigration
{
    public function up()
    {
        $permissions = [
            'view bookings' => ['Owner', 'Executive', 'Staff'],
            'create bookings' => ['Owner', 'Executive'],
            'update bookings' => ['Owner', 'Executive'],
            'view booking categories' => ['Owner', 'Executive', 'Staff'],
            'create booking categories' => ['Owner', 'Executive'],
            'update booking categories' => ['Owner', 'Executive'],
            'view participants' => ['Owner', 'Executive', 'Staff'],
            'view rates' => ['Owner', 'Executive', 'Staff'],
            'create rates' => ['Owner', 'Executive'],
            'update rates' => ['Owner', 'Executive'],
            'view rate categories' => ['Owner', 'Executive', 'Staff'],
            'create rate categories' => ['Owner', 'Executive'],
            'update rate categories' => ['Owner', 'Executive'],
        ];

        $this->createPermissions($permissions);
    }
}
