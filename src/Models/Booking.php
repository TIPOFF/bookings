<?php

declare(strict_types=1);

namespace Tipoff\Bookings\Models;

use Carbon\Carbon;
use Tipoff\Support\Models\BaseModel;
use Tipoff\Support\Traits\HasCreator;
use Tipoff\Support\Traits\HasPackageFactory;
use Tipoff\Support\Traits\HasUpdater;

//Todo: Implement booking interfaces
class Booking extends BaseModel
{
    use HasPackageFactory;
    use HasCreator;
    use HasUpdater;

    protected $with = [
        'rate',
        'experience',
        'order',
        'agent',
        'user',
        'subject',
    ];

    /**
     * Generate amount, total_taxes and total_fees.
     */
    public function generatePricing()
    {
        $this->total_taxes = $this->getTotalTaxes();
        $this->total_amount = $this->getAmountTotal();
        $this->fees = $this->getTotalFees();
    }

    public function getTotalTaxes()
    {
        // @todo: implement taxing
        return null;
    }

    public function getAmountTotal()
    {
        // @todo: implement amounts
        return null;
    }

    public function getTotalFees()
    {
        // @todo: implement fees
        return null;
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
        return $this->morphTo();
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

    public function status()
    {
        return $this->belongsTo(app('status'));
    }

    public function bookingCategory()
    {
        return $this->belongsTo(BookingCategory::class);
    }

    public function subject()
    {
        return $this->morphTo();
    }
}
