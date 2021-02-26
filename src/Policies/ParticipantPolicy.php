<?php

declare(strict_types=1);

namespace Tipoff\Bookings\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Tipoff\Bookings\Models\Participant;
use Tipoff\Support\Contracts\Models\UserInterface;

class ParticipantPolicy
{
    use HandlesAuthorization;

    public function viewAny(UserInterface $user): bool
    {
        return $user->hasPermissionTo('view participants') ? true : false;
    }

    public function view(UserInterface $user, Participant $participant): bool
    {
        return $user->hasPermissionTo('view participants') ? true : false;
    }

    public function create(UserInterface $user): bool
    {
        return false;
    }

    public function update(UserInterface $user, Participant $participant): bool
    {
        return false;
    }

    public function delete(UserInterface $user, Participant $participant): bool
    {
        return false;
    }

    public function restore(UserInterface $user, Participant $participant): bool
    {
        return false;
    }

    public function forceDelete(UserInterface $user, Participant $participant): bool
    {
        return false;
    }
}
