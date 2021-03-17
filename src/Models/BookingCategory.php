<?php

declare(strict_types=1);

namespace Tipoff\Bookings\Models;

use Tipoff\Support\Contracts\Booking\BookingCategoryInterface;
use Tipoff\Support\Models\BaseModel;
use Tipoff\Support\Traits\HasCreator;
use Tipoff\Support\Traits\HasPackageFactory;
use Tipoff\Support\Traits\HasUpdater;

class BookingCategory extends BaseModel implements BookingCategoryInterface
{
    use HasPackageFactory;
    use HasCreator;
    use HasUpdater;

    protected static function boot()
    {
        parent::boot();
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function getLabel()
    {
        return $this->label;
    }
}
