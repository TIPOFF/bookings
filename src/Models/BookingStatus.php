<?php

declare(strict_types=1);

namespace Tipoff\Bookings\Models;

use Tipoff\Support\Models\BaseModel;
use Tipoff\Support\Traits\HasCreator;
use Tipoff\Support\Traits\HasPackageFactory;
use Tipoff\Support\Traits\HasUpdater;

class BookingStatus extends BaseModel
{
    use HasPackageFactory;
    use HasCreator;
    use HasUpdater;
}
