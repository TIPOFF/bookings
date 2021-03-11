<?php

declare(strict_types=1);

namespace Tipoff\Bookings\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Tipoff\Bookings\Models\RateCategory;
use Tipoff\Support\Contracts\Models\UserInterface;

class RateCategoryPolicy
{
    use HandlesAuthorization;

    public function viewAny(UserInterface $user): bool
    {
        return $user->hasPermissionTo('view rate categories') ? true : false;
    }

    public function view(UserInterface $user, RateCategory $rate_category): bool
    {
        return $user->hasPermissionTo('view rate categories') ? true : false;
    }

    public function create(UserInterface $user): bool
    {
        return $user->hasPermissionTo('create rate categories') ? true : false;
    }

    public function update(UserInterface $user, RateCategory $rate_category): bool
    {
        return $user->hasPermissionTo('update rate categories') ? true : false;
    }

    public function delete(UserInterface $user, RateCategory $rate_category): bool
    {
        return false;
    }

    public function restore(UserInterface $user, RateCategory $rate_category): bool
    {
        return false;
    }

    public function forceDelete(UserInterface $user, RateCategory $rate_category): bool
    {
        return false;
    }
}
