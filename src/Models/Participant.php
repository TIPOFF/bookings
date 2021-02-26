<?php

declare(strict_types=1);

namespace Tipoff\Bookings\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Tipoff\Support\Models\BaseModel;
use Tipoff\Support\Traits\HasPackageFactory;

class Participant extends BaseModel
{
    use HasPackageFactory;
    use SoftDeletes;

    protected $casts = [
        'dob' => 'date',
    ];
  
    protected static function boot()
    {
        parent::boot();
    }

    public function user()
    {
        return $this->morphTo();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function feedbacks()
    {
        return $this->hasMany(app('feedback'));
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function signatures()
    {
        return $this->hasMany(app('signature'));
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function bookings()
    {
        return $this->belongsToMany(app('booking'));
    }
}
