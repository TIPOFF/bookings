<?php

declare(strict_types=1);

namespace Tipoff\Bookings\Models;

use Illuminate\Database\Eloquent\Relations\Relation;
use Tipoff\Support\Contracts\Booking\BookingRateCategoryInterface;
use Tipoff\Support\Models\BaseModel;
use Tipoff\Support\Traits\HasCreator;
use Tipoff\Support\Traits\HasPackageFactory;
use Tipoff\Support\Traits\HasUpdater;

class RateCategory extends BaseModel implements BookingRateCategoryInterface
{
    use HasPackageFactory;
    use HasCreator;
    use HasUpdater;

    protected static function boot()
    {
        parent::boot();
    }

    /**
     * Get label used in lists.
     *
     * @return string
     */
    public function getLabel(): string
    {
        return $this->name;
    }

    public function rates(): Relation
    {
        return $this->hasMany(Rate::class);
    }
}
