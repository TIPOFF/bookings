<?php

namespace Tipoff\Bookings\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;
use Tipoff\Support\Nova\BaseResource;

class Rate extends BaseResource
{
    public static $model = \Tipoff\Bookings\Models\Rate::class;

    public static $title = 'name';

    public static $search = [
        'id',
    ];

    public static $group = 'Operations Units';

    public function fieldsForIndex(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),
            Text::make('Slug')->sortable(),
            Text::make('Name')->sortable(),
            Date::make('Created', 'created_at')->sortable()->exceptOnForms(),
        ];
    }

    public function fields(Request $request)
    {
        return [
            Text::make('Name')->rules(['required', 'max:254']),
            Slug::make('Slug')->from('Name')->rules(['required', 'max:254']),
            Text::make('Rate Type')->rules(['required', 'max:254']),
            Number::make('Participants Limit')->rules(['required', 'max:254']),
            nova('rate_category') ? BelongsTo::make('Rate Category', 'rate_category', nova('rate_category')) : null,

            new Panel('Money Fields', $this->moneyFields()),

            nova('room') ? HasMany::make('Rooms', 'rooms', nova('room')) : null,

            new Panel('Data Fields', $this->dataFields()),

            nova('booking') ? HasMany::make('Bookings', 'bookings', nova('booking')) : null,
        ];
    }

    protected function moneyFields()
    {
        return [
            Currency::make('Amount', 'amount')->asMinorUnits()
                ->step('0.01')
                ->resolveUsing(function ($value) {
                    return $value / 100;
                })
                ->fillUsing(function ($request, $model, $attribute) {
                    $model->$attribute = $request->$attribute * 100;
                })->required(),
        ];
    }

    protected function dataFields(): array
    {
        return array_merge(
            parent::dataFields(),
            $this->creatorDataFields(),
            $this->updaterDataFields(),
        );
    }
}
