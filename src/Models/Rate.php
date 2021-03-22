<?php

declare(strict_types=1);

namespace Tipoff\Bookings\Models;

use Illuminate\Database\Eloquent\Relations\Relation;
use Tipoff\Support\Contracts\Booking\BookingRateCategoryInterface;
use Tipoff\Support\Contracts\Booking\BookingRateInterface;
use Tipoff\Support\Models\BaseModel;
use Tipoff\Support\Traits\HasPackageFactory;

class Rate extends BaseModel implements BookingRateInterface
{
    use HasPackageFactory;

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

    public function getSlug(): string
    {
        // @todo Slug Interface method
        return '';
    }

    public function getAmount(): int
    {
        // @todo Amount Interface method
        return 0;
    }

    public function getLabel(): string
    {
        return $this->name;
    }

    public function getCategory(): BookingRateCategoryInterface
    {
        return $this->category;
    }

    public function category(): Relation
    {
        return $this->rate_category;
    }

    /**
     * Get number of participants for the rate.
     *
     * @return int|null
     */
    public function getParticipantsLimit(): ?int
    {
        return $this->participants_limit;
    }

    public function getRouteKeyName()
    {
        return 'slug';
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
        return $this->hasMany(app('booking'));
    }

    public function schedules()
    {
        return $this->hasMany(app('schedule'));
    }
}
