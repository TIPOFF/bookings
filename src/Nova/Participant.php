<?php

namespace Tipoff\Bookings\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\Badge;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Tipoff\Support\Nova\BaseResource;

class Participant extends BaseResource
{
    public static $model = \Tipoff\Bookings\Models\Participant::class;

    public static $title = 'email';

    public static $search = [
        'id',
    ];

    public static $group = 'Access';

    public function fieldsForIndex(NovaRequest $request)
    {
        return array_filter([
            ID::make()->sortable(),
            Text::make('Name', function () {
                return $this->name . ' ' . $this->name_last;
            }),
            Text::make('Email'),
            DateTime::make('Created', 'created_at')->sortable(),
        ]);
    }

    public function fields(Request $request)
    {
        return array_filter([
            nova('user') ? BelongsTo::make('User', 'user', nova('user'))->searchable()->withSubtitles()->withoutTrashed() : null,
            Text::make('First Name', 'name'),
            Text::make('Last Name', 'name_last'),
            Text::make('Email'),
            Badge::make('Valid Email', function () {
                if (isset($this->deleted_at)) {
                    return 'No';
                }

                return 'Yes';
            })->map([
                'No' => 'danger',
                'Yes' => 'success',
            ]),
            Date::make('Date of Birth', 'dob'),
            DateTime::make('Created', 'created_at'),

            ID::make(),

            nova('feedback') ? HasMany::make('Feedbacks', 'feedbacks', nova('feedback')) : null,

            nova('signature') ? HasMany::make('Signatures', 'signatures', nova('signature')) : null,
        ]);
    }
}
