<?php

declare(strict_types=1);

namespace Tipoff\Bookings\Models;

use Tipoff\Support\Models\BaseModel;
use Tipoff\Support\Traits\HasCreator;
use Tipoff\Support\Traits\HasPackageFactory;
use Tipoff\Support\Traits\HasUpdater;

class Participant extends BaseModel
{
    use HasPackageFactory;
    // Todo: Should this still be included?
    //use HasMedia;
    use HasCreator;
    use HasUpdater;

    protected $casts = [
        'dob' => 'date',
    ];

    public function user()
    {
        return $this->morphTo(app('user'));
    }
}
