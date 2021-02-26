<?php

declare(strict_types=1);

namespace Tipoff\Bookings\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Tipoff\Support\Models\BaseModel;
use Tipoff\Support\Traits\HasPackageFactory;
use Tipoff\Support\Traits\HasUpdater;

class Slot extends BaseModel
{
    use HasPackageFactory;
    use HasUpdater;

    protected $casts = [
        'date' => 'datetime',
        'start_at' => 'datetime',
        'end_at' => 'datetime',
        'room_available_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($slot) {
            if (empty($slot->room_id)) {
                throw new \Exception('An availability slot must be for a room.');
            }
            if (empty($slot->start_at)) {
                throw new \Exception('An availability slot must have a date & time.');
            }

            /** @var Model $roomModel */
            $roomModel = app('room');
            $room = $roomModel::findOrFail($slot->room_id);

            if (empty($slot->rate_id)) {
                $slot->rate_id = $room->rate_id;
            }
            if (empty($slot->supervision_id)) {
                $slot->supervision_id = $room->supervision_id;
            }

            $slot
                ->generateDates()
                ->generateSlotNumber()
                ->updateParticipants();
        });
    }

    /**
     * Find slots active at time range (UTC).
     *
     * @param string $initialTime
     * @param string $finalTime
     * @return bool
     */
    public function isActiveAtTimeRange($initialTime, $finalTime)
    {
        $initialTime = Carbon::parse($initialTime, 'UTC');
        $finalTime = Carbon::parse($finalTime, 'UTC');

        if (
            ($this->start_at >= $initialTime && $this->start_at <= $finalTime) ||
            ($this->room_available_at >= $initialTime && $this->room_available_at <= $finalTime) ||
            ($this->start_at <= $initialTime && $this->room_available_at >= $finalTime)
        ) {
            return true;
        }

        return false;
    }

    public function generateDates()
    {
        $this->date = Carbon::parse($this->start_at)->setTimeZone($this->room->location->php_tz)->toDateString();
        $this->end_at = Carbon::parse($this->start_at)->addMinutes($this->room->theme->duration);
        $this->room_available_at = Carbon::parse($this->start_at)->addMinutes($this->room->occupied_time);

        return $this;
    }

    public function generateSlotNumber()
    {
        if ($this->date instanceof \Illuminate\Support\Carbon) {
            $slotDate = $this->date->toDateString();
        } else {
            $slotDate = $this->date;
        }
        
        $slotNumber = str_replace('-', '', substr($slotDate, 2, 8))
            . (string)$this->start_at->format('Hi')
            . '-' . $this->room->location_id
            . '-' . $this->room->id;

        $this->slot_number = $slotNumber;

        return $this;
    }

    public function updateParticipants()
    {
        if (empty($this->participants)) {
            $this->participants = 0;
        }
        if (empty($this->participants_blocked)) {
            $this->participants_blocked = 0;
        }
        $available = $this->room->participants - ($this->participants + $this->participants_blocked);
        if ($available < 0) {
            $available = 0;
        }
        $this->participants_available = $available;

        return $this;
    }

    /**
     * Check if slot has locks.
     *
     * @return bool
     */
    public function hasHold()
    {
        return Cache::has($this->getHoldCacheKey());
    }

    /**
     * Get hold for slot.
     *
     * @return object|null
     */
    public function getHold()
    {
        return Cache::get($this->getHoldCacheKey());
    }

    /**
     * Relese slot hold.
     *
     * @return self
     */
    public function releaseHold()
    {
        Cache::delete($this->getHoldCacheKey());

        return $this;
    }

    /**
     * Get location time.
     *
     * @return string
     */
    public function getTimeAttribute()
    {
        return $this->getCarbonStartAt()->setTimezone($this->room->location->php_tz)->format('g:i A');
    }

    /**
     * Create hold.
     *
     * @param int $userId
     * @param Carbon|null $expiresAt
     * @return self
     */
    public function setHold($userId, $expiresAt = null)
    {
        if (empty($expiresAt)) {
            $expiresAt = now()->addSeconds(config('services.slot.hold.lifetime', 600));
        }

        Cache::put(
            $this->getHoldCacheKey(),
            ['user_id' => $userId, 'expires_at' => (string)$expiresAt],
            $expiresAt
        );

        return $this;
    }

    public static function setSessionHold(array $slotData): void
    {
        Session::put('guest:hold', $slotData);

        self::resolveSlot($slotData['slot_number'])
            ->setHold((int)Session::getId());
    }

    /**
     * Get cache key used for hold.
     *
     * @return string
     */
    public function getHoldCacheKey()
    {
        return 'slot.' . $this->slot_number . '.hold';
    }

    public function getTitleAttribute()
    {
        return $this->room->name . ' ' . $this->getCarbonStartAt()->setTimeZone($this->room->location->php_tz)->format('Y-m-d g:i A');
    }

    public function getLocationStartAttribute()
    {
        return $this->getCarbonStartAt()->setTimeZone($this->room->location->php_tz);
    }

    public function getLocationEndAttribute()
    {
        return Carbon::parse($this->end_at)->setTimeZone($this->room->location->php_tz);
    }

    public function getLocationAvailableAttribute()
    {
        return Carbon::parse($this->room_available_at)->setTimeZone($this->room->location->php_tz);
    }

    public function getFormattedStartAttribute()
    {
        return $this->location_start->format('D\, M j \- g\:i A');
    }

    public function schedule()
    {
        return $this->morphTo();
    }

    public function room()
    {
        return $this->belongsTo(app('room'));
    }

    public function rate()
    {
        return $this->belongsTo(app('rate'));
    }

    public function game()
    {
        return $this->hasOne(app('game'));
    }

    public function supervision()
    {
        return $this->belongsTo(app('supervision'));
    }

    public function location()
    {
        return $this->hasOneThrough(app('location'), app('room'), 'id', 'id', 'room_id', 'location_id');
    }

    public function blocks()
    {
        return $this->hasMany(app('block'));
    }

    public function bookings()
    {
        return $this->hasMany(app('booking'));
    }

    /**
     * Scope slots to specific location.
     *
     * Accept: ;ocation model, location id, location slug.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $location
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeLocation($query, $location)
    {
        /** @var Model $locationModel */
        $locationModel = app('location');

        if ($location instanceof $locationModel) {
            $location = $location->id;
        }

        return $query->whereHas('room', function ($query) use ($location, $locationModel) {
            if (is_string($location)) {
                $location = $locationModel::whereSlug($location)->firstOrFail(['id'])->id;
            }

            return $query->where('location_id', $location);
        });
    }

    /**
     * Get hold attribute.
     *
     * @return null|object
     */
    public function getHoldAttribute()
    {
        return $this->getHold();
    }

    public function notes()
    {
        return $this->morphMany(app('note'), 'noteable');
    }

    /**
     * Get rate for slot.
     *
     * @return mixed
     */
    public function getRate()
    {
        return $this->rate;
    }

    /**
     * Get tax for slot.
     *
     * @return mixed
     */
    public function getTax()
    {
        return $this->room->location->bookingTax;
    }

    /**
     * Get fee for slot.
     *
     * @return mixed
     */
    public function getFee()
    {
        return $this->room->location->bookingFee;
    }

    /**
     * Get start at Carbon.
     *
     * @return Carbon
     */
    public function getCarbonStartAt()
    {
        return Carbon::parse($this->start_at);
    }

    /**
     * Check if slot is bookable.
     *
     * @return bool
     */
    public function isBookable()
    {
        if ($this->getCarbonStartAt() < Carbon::now('UTC')->add('20 minutes')) {
            return false;
        }

        if ($this->getCarbonStartAt() > Carbon::now('UTC')->add('6 months')) {
            return false;
        }

        return true;
    }

    /**
     * Check if slot is virtual.
     *
     * @return bool
     */
    public function isVirtual()
    {
        return ! $this->exists;
    }

    /**
     * Check if slot is recurring.
     *
     * @return bool
     */
    public function isRecurring()
    {
        return $this->schedule_type == 'recurring_schedules';
    }

    /**
     * Find existing or virtual slot.
     *
     * @param string $slotNumber
     * @return Slot|null
     */
    public static function resolveSlot($slotNumber)
    {
        $slot = self::where('slot_number', $slotNumber)
            ->first();

        // Virtual  Slots
        if (! $slot) {
            /** @var string $slotCollection */
            $slotCollection = config('bookings.collection_class.slot');

            // TODO - pull in calendar service so it can be used
            if (app()->has(config('bookings.service_class.calendar'))) {
                $calendarService = app(config('bookings.service_class.calendar'));
                $date = $calendarService->generateDateFromSlotNumber($slotNumber);
                $locationId = $calendarService->getLocationIdBySlotNumber($slotNumber);
                $recurringSchedules = $calendarService->getLocationRecurringScheduleForDateRange($locationId, $date, $date);
                $slots = new $slotCollection; //@TODO phuclh Need to refactor this line later.
                $slot = $slots
                    ->applyRecurringSchedules($recurringSchedules, $date)
                    ->where('slot_number', $slotNumber)
                    ->first();
            }
        }

        return $slot;
    }
}
