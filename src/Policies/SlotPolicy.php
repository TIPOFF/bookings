<?php

declare(strict_types=1);

namespace Tipoff\Bookings\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Tipoff\Bookings\Models\Slot;
use Tipoff\Support\Contracts\Models\UserInterface;

class SlotPolicy
{
    use HandlesAuthorization;

    public function viewAny(UserInterface $user): bool
    {
        return $user->hasPermissionTo('view slots') ? true : false;
    }

    public function view(UserInterface $user, Slot $slot): bool
    {
        return $user->hasPermissionTo('view slots') ? true : false;
    }

    public function create(UserInterface $user): bool
    {
        return $user->hasPermissionTo('create slots') ? true : false;
    }

    public function update(UserInterface $user, Slot $slot): bool
    {
        return $user->hasPermissionTo('update slots') ? true : false;
    }

    public function delete(UserInterface $user, Slot $slot): bool
    {
        return false;
    }

    public function restore(UserInterface $user, Slot $slot): bool
    {
        return false;
    }

    public function forceDelete(UserInterface $user, Slot $slot): bool
    {
        return false;
    }
}
