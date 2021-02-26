<?php

declare(strict_types=1);

namespace Tipoff\Bookings\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Tipoff\Support\Models\BaseModel;
use Tipoff\Bookings\Models\Booking;

class BookingStatus extends BaseModel
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