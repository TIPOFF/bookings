<?php

declare(strict_types=1);

namespace Tipoff\Bookings\Models;

use Carbon\Carbon;
use Tipoff\Support\Models\BaseModel;
use Tipoff\Support\Traits\HasCreator;
use Tipoff\Support\Traits\HasPackageFactory;
use Tipoff\Support\Traits\HasUpdater;

class Booking extends BaseModel
{
    use HasPackageFactory;
    use HasCreator;
    use HasUpdater;

    protected $with = [
        'variation',
        'experience',
        'order',
        'agent',
        'user',
        'subject',
    ];

    public function computeTaxes()
    {
        return $this->amount * ($this->tax->percent / 100);
    }

    public function scopeYesterday($query)
    {
        $start = Carbon::now('America/New_York')->startOfDay()->subDays(1)->setTimeZone('UTC');
        $end = Carbon::now('America/New_York')->startOfDay()->setTimeZone('UTC');

        return $query->where('created_at', '>=', $start)->where('created_at', '<=', $end);
    }

    public function scopeYesterdayComparison($query)
    {
        $start = Carbon::now('America/New_York')->startOfDay()->subDays(8)->setTimeZone('UTC');
        $end = Carbon::now('America/New_York')->startOfDay()->subDays(7)->setTimeZone('UTC');

        return $query->where('created_at', '>=', $start)->where('created_at', '<=', $end);
    }

    public function scopeWeek($query)
    {
        $start = Carbon::now('America/New_York')->startOfDay()->subDays(7)->setTimeZone('UTC');
        $end = Carbon::now('America/New_York')->startOfDay()->setTimeZone('UTC');

        return $query->where('created_at', '>=', $start)->where('created_at', '<=', $end);
    }

    public function scopeWeekComparison($query)
    {
        $start = Carbon::now('America/New_York')->startOfDay()->subDays(14)->setTimeZone('UTC');
        $end = Carbon::now('America/New_York')->startOfDay()->subDays(7)->setTimeZone('UTC');

        return $query->where('created_at', '>=', $start)->where('created_at', '<=', $end);
    }

    // Todo: Determine Morph Relation Type
    public function variation()
    {
        return $this->morphToMany(app('variation'), 'variation');
    }

    public function experience()
    {
        return $this->morphToMany(app('experience'), 'experience');
    }

    public function order()
    {
        return $this->morphToMany(app('order'), 'order');
    }

    public function agent()
    {
        return $this->morphToMany(app('agent'), 'agent');
    }

    public function user()
    {
        return $this->morphToMany(app('user'), 'user');
    }

    public function bookingStatus()
    {
        return $this->belongsTo(BookingStatus::class);
    }

    public function bookingCategory()
    {
        return $this->belongsTo(BookingCategory::class);
    }

    public function variation()
    {
        return $this->morphTo();
    }

    public function experience()
    {
        return $this->morphTo();
    }

    public function subject()
    {
        return $this->morphTo();
    }
}
