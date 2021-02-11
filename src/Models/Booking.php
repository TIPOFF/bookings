<?php namespace Tipoff\Bookings\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Tipoff\Support\Models\BaseModel;

class Booking extends BaseModel
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    protected $casts = [
    ];

    protected $with = [
        'order',
        'slot',
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
     * @return self
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

    public function order()
    {
        return $this->belongsTo(app('order'));
    }

    public function slot()
    {
        return $this->belongsTo(app('slot'));
    }

    public function room()
    {
        return $this->hasOneThrough(app('room'), app('slot'), 'id', 'id', 'slot_id', 'room_id');
    }

    public function rate()
    {
        return $this->belongsTo(app('rate'));
    }

    public function tax()
    {
        return $this->belongsTo(app('tax'));
    }

    public function fee()
    {
        return $this->belongsTo(app('fee'));
    }

    public function participants()
    {
        return $this->belongsToMany(app('participant'));
    }

    public function signatures()
    {
        return $this->hasMany(app('signature'));
    }

    public function notes()
    {
        return $this->morphMany(app('note'), 'noteable');
    }
}
