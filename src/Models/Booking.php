<?php

declare(strict_types=1);

namespace Tipoff\Bookings\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\Relation;
use Tipoff\Bookings\Enums\BookingStatus;
use Tipoff\Statuses\Traits\HasStatuses;
use Tipoff\Support\Contracts\Booking\BookingExperienceInterface;
use Tipoff\Support\Contracts\Booking\BookingInterface;
use Tipoff\Support\Contracts\Booking\BookingSlotInterface;
use Tipoff\Support\Contracts\Booking\BookingSubjectInterface;
use Tipoff\Support\Models\BaseModel;
use Tipoff\Support\Traits\HasCreator;
use Tipoff\Support\Traits\HasPackageFactory;
use Tipoff\Support\Traits\HasUpdater;

//Todo: Implement booking interfaces
class Booking extends BaseModel implements BookingInterface
{
    use HasPackageFactory;
    use HasCreator;
    use HasUpdater;
    use HasStatuses;

    protected $with = [
        'rate',
        'experience',
        'order',
        'agent',
        'user',
        'subject',
    ];

    public function getLabel(): string
    {
        return $this->getSubject()->getLabel();
    }

    public function getTimezone(): string
    {
        return $this->getSlot()->getTimezone();
    }

    public function getDescription(): string
    {
        $date = strtoupper(
            $this
                ->getSlot()
                ->getStartAt()
                ->setTimezone($this->getTimezone())
                ->format('D\, M j')
        );
        $arrival = $this
            ->getSlot()
            ->getStartAt()
            ->setTimezone($this->getTimezone())
            ->subMinutes(15)
            ->format('g:i A');

        $start = $this
            ->getSlot()
            ->getStartAt()
            ->setTimezone($this->getTimezone())
            ->format('g:i A');

        return $date.' ⬩ ARRIVE BY '.$arrival.' ⬩ STARTS AT '.$start;
    }

    public function getDate(): Carbon
    {
        return $this->getSlot()->getDate();
    }

    public function participants(): Relation
    {
        return $this->belongsToMany(app('participant'));
    }

    public function getSubject(): BookingSubjectInterface
    {
        return $this->subject;
    }

    /**
     * Get slot.
     *
     * @return BookingSlotInterface
     */
    public function getSlot(): BookingSlotInterface
    {
        return $this->slot;
    }

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

    public function getAmount(): int
    {
        // @todo: implement amounts
        return 0;
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

    public function experience(): Relation
    {
        return $this->morphTo();
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
        return $this->belongsTo(app('booking_category'));
    }

    public function subject(): Relation
    {
        return $this->morphTo();
    }

    public function getExperience(): BookingExperienceInterface
    {
        return $this->experience;
    }

    public function setBookingStatus(BookingStatus $bookingStatus): self
    {
        $this->setStatus((string) $bookingStatus->getValue(), BookingStatus::statusType());

        return $this;
    }

    public function getBookingStatus(): ?BookingStatus
    {
        $status = $this->getStatus(BookingStatus::statusType());

        return $status ? BookingStatus::byValue((string) $status) : null;
    }
}
