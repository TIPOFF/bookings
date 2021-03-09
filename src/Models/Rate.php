<?php

declare(strict_types=1);

namespace Tipoff\Bookings\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $casts = [
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($rate) {
            if (auth()->check()) {
                $rate->creator_id = auth()->id();
            }
        });

        static::saving(function ($rate) {
            if (auth()->check()) {
                $rate->updater_id = auth()->id();
            }
            //Todo: Implement BookingRateInterface
//            if (empty($rate->getSlug())) {
//                throw new \Exception('A rate must have a slug.');
//            }
//            if (empty($rate->getAmount())) {
//                throw new \Exception('A rate must have a base amount.');
//            }
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Generate amount.
     *
     * @param int $participants
     * @param bool $isPrivate
     * @return int
     */
    public function getAmount(int $participants, bool $isPrivate)
    {
        $key = ($isPrivate) ? 'private_' : 'public_';
        $key = $key.$participants;

        return $this->$key * $participants;
    }

    public function creator()
    {
        return $this->belongsTo(app('user'), 'creator_id');
    }

    public function updater()
    {
        return $this->belongsTo(app('user'), 'updater_id');
    }

    public function rooms()
    {
        return $this->hasMany(app('room'));
    }

    public function slots()
    {
        return $this->hasMany(app('slot'));
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function schedules()
    {
        return $this->hasMany(app('schedule'));
    }
}
