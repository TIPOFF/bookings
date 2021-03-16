<?php

declare(strict_types=1);

namespace Tipoff\Bookings\Enums;

use Tipoff\Statuses\Models\Status;
use Tipoff\Support\Enums\BaseEnum;

/**
 * @method static BookingStatus PROCESSING()
 * @method static BookingStatus COMPLETE()
 * @psalm-immutable
 */
class BookingStatus extends BaseEnum
{
    const PENDING = 'Pending';
    const COMPLETE = 'Complete';
    const CANCELLED = 'Cancelled';

    public static function statusType(): string
    {
        return StatusType::BOOKING;
    }

    public function toStatus(): ?Status
    {
        /** @psalm-suppress ImpureMethodCall */
        return Status::findStatus(static::statusType(), (string) $this->getValue());
    }
}
