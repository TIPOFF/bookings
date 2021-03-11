<?php

declare(strict_types=1);

namespace Tipoff\Bookings\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Tipoff\Bookings\Models\BookingCategory;
use Tipoff\Support\Contracts\Models\UserInterface;

class BookingCategoryPolicy
{
    use HandlesAuthorization;

    public function viewAny(UserInterface $user): bool
    {
        return $user->hasPermissionTo('view booking categories') ? true : false;
    }

    public function view(UserInterface $user, BookingCategory $booking_category): bool
    {
        return $user->hasPermissionTo('view booking categories') ? true : false;
    }

    public function create(UserInterface $user): bool
    {
        return false;
    }

    public function update(UserInterface $user, BookingCategory $booking_category): bool
    {
        return false;
    }

    public function delete(UserInterface $user, BookingCategory $booking_category): bool
    {
        return false;
    }

    public function restore(UserInterface $user, BookingCategory $booking_category): bool
    {
        return false;
    }

    public function forceDelete(UserInterface $user, BookingCategory $booking_category): bool
    {
        return false;
    }
}
