<?php

declare(strict_types=1);

namespace Tipoff\Bookings\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Tipoff\Bookings\Models\Booking;
use Tipoff\Support\Contracts\Models\UserInterface;

class BookingPolicy
{
    use HandlesAuthorization;

    public function viewAny(UserInterface $user): bool
    {
        return $user->hasPermissionTo('view bookings') ? true : false;
    }

    public function view(UserInterface $user, Booking $booking): bool
    {
        return $user->hasPermissionTo('view bookings') ? true : false;
    }

    public function create(UserInterface $user): bool
    {
        return $user->hasPermissionTo('create bookings') ? true : false;
    }

    public function update(UserInterface $user, Booking $booking): bool
    {
        return $user->hasPermissionTo('update bookings') ? true : false;
    }

    public function delete(UserInterface $user, Booking $booking): bool
    {
        return false;
    }

    public function restore(UserInterface $user, Booking $booking): bool
    {
        return false;
    }

    public function forceDelete(UserInterface $user, Booking $booking): bool
    {
        return false;
    }
}
