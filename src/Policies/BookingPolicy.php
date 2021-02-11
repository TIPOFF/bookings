<?php

declare(strict_types=1);

namespace Tipoff\Bookings\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Tipoff\Bookings\Models\Booking;
use Tipoff\Support\Contracts\Models\UserInterface;

class BookingPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(UserInterface $user): bool
    {
        return $user->hasPermissionTo('view bookings') ? true : false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Booking  $booking
     * @return mixed
     */
    public function view(UserInterface $user, Booking $booking): bool
    {
        return $user->hasPermissionTo('view bookings') ? true : false;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(UserInterface $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Booking  $booking
     * @return mixed
     */
    public function update(UserInterface $user, Booking $booking): bool
    {
        return $user->hasPermissionTo('update bookings') ? true : false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Booking  $booking
     * @return mixed
     */
    public function delete(UserInterface $user, Booking $booking): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Booking  $booking
     * @return mixed
     */
    public function restore(UserInterface $user, Booking $booking): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Booking  $booking
     * @return mixed
     */
    public function forceDelete(UserInterface $user, Booking $booking): bool
    {
        return false;
    }
}
