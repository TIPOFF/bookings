<?php

declare(strict_types=1);

namespace Tipoff\Bookings\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;
use Tipoff\Support\Nova\BaseResource;

class Company extends BaseResource
{
    public static $model = \Tipoff\Bookings\Models\BookingCategory::class;

    public static $title = 'name';

    public static $search = [
        'id',
    ];

    public function fieldsForIndex(NovaRequest $request)
    {
        return array_filter([
            ID::make()->sortable(),
        ]);
    }

    public function fields(Request $request)
    {
        return array_filter([
            Text::make('Name')->required(),
            nova('booking') ? HasMany::make('Bookings', 'bookings', nova('booking')) : null,

            new Panel('Data Fields', $this->dataFields()),
        ]);
    }

    public function dataFields(): array
    {
        return array_merge(
            parent::dataFields(),
            [
                DateTime::make('Created At')->exceptOnForms(),
                DateTime::make('Updated At')->exceptOnForms(),
            ]
        );
    }
}
