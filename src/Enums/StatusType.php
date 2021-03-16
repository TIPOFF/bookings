<?php

declare(strict_types=1);

namespace Tipoff\Bookings\Enums;

use Tipoff\Support\Enums\BaseEnum;

/**
 * @method static StatusTypes BOOKING()
 * @psalm-immutable
 */
class StatusType extends BaseEnum
{
    const BOOKING = 'booking';
}
