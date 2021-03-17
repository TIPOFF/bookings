<?php

declare(strict_types=1);

namespace Tipoff\Bookings\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Tipoff\Support\Contracts\Booking\BookingParticipantInterface;
use Tipoff\Support\Contracts\Models\UserInterface;
use Tipoff\Support\Models\BaseModel;
use Tipoff\Support\Traits\HasCreator;
use Tipoff\Support\Traits\HasPackageFactory;
use Tipoff\Support\Traits\HasUpdater;

class Participant extends BaseModel implements BookingParticipantInterface
{
    use HasPackageFactory;
    use HasCreator;
    use HasUpdater;
    use SoftDeletes;

    protected $casts = [
        'dob' => 'date',
    ];
  
    protected static function boot()
    {
        parent::boot();
    }

    /**
     * Get label used in lists.
     *
     * @return string
     */
    public function getLabel(): string
    {
        return $this->first_name + ' ' + $this->last_name;
    }

    /**
     * Get email.
     *
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Check is participant account verified.
     *
     * @return bool
     */
    public function isVerified(): bool
    {
        return $this->is_verified;
    }

    /**
     * Returns the user that owns the container
     *
     * @return UserInterface
     */
    public function getUser(): UserInterface
    {
        return $this->user;
    }

    public function user()
    {
        return $this->morphTo(app('user'));
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function feedbacks()
    {
        return $this->hasMany(app('feedback'));
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function signatures()
    {
        return $this->hasMany(app('signature'));
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function bookings()
    {
        return $this->belongsToMany(app('booking'));
    }
}
