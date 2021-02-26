<?php

declare(strict_types=1);

namespace Tipoff\Bookings\Nova\Filters;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Laravel\Nova\Filters\DateFilter;

class SlotDayFilter extends DateFilter
{
    /**
     * The displayable name of the filter.
     *
     * @var string
     */
    public $name = 'Game Date';

    /**
     * Apply the filter to the given query.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(Request $request, $query, $value)
    {
        return $query
            ->join('slots', 'slots.id', 'slot_id')
            ->where('slots.date', Carbon::parse($value));
    }
}
