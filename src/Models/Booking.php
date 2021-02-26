<?php

declare(strict_types=1);

namespace Tipoff\Bookings\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Tipoff\Support\Models\BaseModel;
use Tipoff\Bookings\Models\BookingStatus;
use Tipoff\Bookings\Models\BookingCategory;

class Booking extends BaseModel
{
    use HasFactory;

    protected $casts = [
    ];

    protected $with = [
        'order',
    ];

    protected $appends = [
        'date',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($booking) {
            if (empty($booking->order_id)) {
                throw new \Exception('A booking must be part of an order.');
            }
            if (empty($booking->slot_id)) {
                throw new \Exception('A booking must be for an availability slot.');
            }
        });
    }

    /**
     * Generate amount, total_taxes and total_fees.
     *
     * !!! This funcionaly is uswed mainly by seeder !!!
     *
     * @return void
     */
    public function generatePricing()
    {
        if (empty($this->rate_id)) {
            $this->rate_id = $this->slot->rate_id;
        }
        if (empty($this->tax_id)) {
            $this->tax_id = $this->slot->location->booking_tax_id;
        }
        if (empty($this->fee_id)) {
            $this->fee_id = $this->slot->location->booking_fee_id;
        }

        $this->amount = $this->computeAmount();
        $this->total_taxes = $this->computeTaxes();
        $this->total_fees = $this->computeFees();
    }

    public function computeAmount()
    {
        if ($this->is_private) {
            $ratefield = 'private_'.$this->participants;
        } else {
            $ratefield = 'public_'.$this->participants;
        }

        return $this->participants * $this->rate->{ $ratefield };
    }

    public function computeTaxes()
    {
        return $this->amount * ($this->tax->percent / 100);
    }

    public function computeFees()
    {
        // @todo Need to finsih this with the different ways fees can be applied.
        return 0;
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

    public function getDetailsAttribute()
    {
        $date = strtoupper($this->slot->getCarbonStartAt()->setTimezone($this->slot->room->location->php_tz)->format('D\, M j'));
        $arrival = $this->slot->getCarbonStartAt()->setTimezone($this->slot->room->location->php_tz)->subMinutes(15)->format('g:i A');
        $start = $this->slot->getCarbonStartAt()->setTimezone($this->slot->room->location->php_tz)->format('g:i A');

        return $date.' ⬩ ARRIVE BY '.$arrival.' ⬩ STARTS AT '.$start;
    }

    public function getSlotStartAttribute()
    {
        return $this->slot->start_at;
    }

    public function getDateAttribute()
    {
        return Carbon::parse($this->created_at)->setTimeZone($this->order->location->php_tz)->toDateString();
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

    public function order()
    {
        return $this->morphTo();
    }

    public function agent()
    {
        return $this->morphTo();
    }

    public function subject()
    {
        return $this->morphTo();
    }

}
