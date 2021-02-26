<?php

declare(strict_types=1);

namespace Tipoff\Bookings\Nova\Filters;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Laravel\Nova\Filters\BooleanFilter;

class FutureSlots extends BooleanFilter
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
        if ($value['future'] == true && $value['past'] == true) {
            return $query;
        }

        if ($value['future'] == true) {
            return $query->where('start_at', '>', Carbon::now());
        }

        if ($value['past'] == true) {
            return $query->where('start_at', '<', Carbon::now());
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
            'Future' => 'future',
            'Past' => 'past',
        ];
    }

    public function default()
    {
        return [
            'future' => true,
            'past' => false,
        ];
    }
}
