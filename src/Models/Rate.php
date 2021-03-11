<?php

declare(strict_types=1);

namespace Tipoff\Bookings\Models;

use Carbon\Carbon;
use Tipoff\Support\Models\BaseModel;
use Tipoff\Support\Traits\HasPackageFactory;

class Rate extends BaseModel
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

    public function getSlug()
    {
        // @todo Slug Interface method
    }

    public function getAmount()
    {
        // @todo Amount Interface method
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
        return $this->hasMany(Booking::class);
    }

    public function schedules()
    {
        return $this->hasMany(app('schedule'));
    }
}
