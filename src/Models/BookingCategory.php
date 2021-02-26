<?php

declare(strict_types=1);

namespace Tipoff\Bookings\Models;

use Tipoff\Support\Models\BaseModel;

class BookingCategory extends BaseModel
{
    protected static function boot()
    {
        parent::boot();
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
