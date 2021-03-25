<?php

declare(strict_types=1);

namespace Tipoff\Scheduler\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\Relation;
use Tipoff\Support\Contracts\Booking\BookingSlotInterface;
use Tipoff\Support\Models\BaseModel;
use Tipoff\Support\Traits\HasPackageFactory;
use Tipoff\Support\Traits\HasUpdater;

class BookingSlot extends BaseModel implements BookingSlotInterface
{
    use HasPackageFactory;
    use HasUpdater;

    protected $casts = [
        'date' => 'datetime',
        'start_at' => 'datetime',
        'end_at' => 'datetime',
    ];

    /**
     * Resolve slot by number.
     *
     * @param  string $slotNumber
     * @return self
     */
    public function resolveSlot($slotNumber): self
    {
        return $this;
    }

    /**
     * Check if slot has locks.
     *
     * @return bool
     */
    public function hasHold(): bool
    {
        return false;
    }

    /**
     * Get hold for slot.
     *
     * @return object|null
     */
    public function getHold()
    {
        return null;
    }

    /**
     * Relese slot hold.
     *
     * @return self
     */
    public function releaseHold(): self
    {
        return $this;
    }

    /**
     * @param string $initialTime
     * @param string $finalTime
     * @return bool
     */
    public function isActiveAtTimeRange($initialTime, $finalTime): bool
    {
        return false;
    }

    /**
     * Get timezone.
     *
     * @return string
     */
    public function getTimezone(): string
    {
        return 'UTC';
    }

    /**
     * Get local time.
     *
     * @return Carbon
     */
    public function getTime(): Carbon
    {
        return now();
    }

    /**
     * Get label used in lists.
     *
     * @return string
     */
    public function getLabel(): string
    {
        return 'Booking';
    }

    /**
     * Get booking date.
     *
     * @return Carbon
     */
    public function getDate(): Carbon
    {
        return now();
    }

    /**
     * Get start at.
     *
     * @return Carbon
     */
    public function getStartAt(): Carbon
    {
        return now();
    }

    /**
     * Get end at.
     *
     * @return Carbon
     */
    public function getEndAt(): Carbon
    {
        return now();
    }

    /**
     * If slot is virtual (not stored).
     *
     * @return bool
     */
    public function isVirtual(): bool
    {
        return false;
    }

    /**
     * Create hold.
     *
     * @param int $id For example user id.
     * @param Carbon|null $expiresAt
     * @return self
     */
    public function setHold($id, ?Carbon $expiresAt): self
    {
        return $this;
    }

    /**
     * Check if slot is bookable.
     *
     * @return bool
     */
    public function isBookable(): bool
    {
        return true;
    }

    public function bookings(): Relation
    {
        return $this->hasMany(app('booking'));
    }
}
