<?php

declare(strict_types=1);

namespace Tipoff\Bookings\Nova\Filters;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Laravel\Nova\Filters\BooleanFilter;

class RealizedBookings extends BooleanFilter
{
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
        if ($value['unrealized'] == true && $value['realized'] == true) {
            return $query;
        }

        if ($value['unrealized'] == true) {
            return $query->whereHas('slot', function ($query) {
                $query->where('slots.start_at', '>', Carbon::now());
            });
        }

        if ($value['realized'] == true) {
            return $query->whereHas('slot', function ($query) {
                $query->where('slots.start_at', '<', Carbon::now());
            });
        }

        return $query;
    }

    /**
     * Get the filter's available options.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function options(Request $request)
    {
        return [
            'Unrealized' => 'unrealized',
            'Realized' => 'realized',
        ];
    }

    public function default()
    {
        return [
            'unrealized' => true,
            'realized' => false,
        ];
    }
}
