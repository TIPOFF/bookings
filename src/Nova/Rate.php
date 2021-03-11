<?php

namespace Tipoff\Bookings\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
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
            Text::make('Name')->required(),
            Slug::make('Slug')->from('Name'),

            new Panel('Money Fields', $this->moneyFields()),

            HasMany::make('Rooms'),

            new Panel('Data Fields', $this->dataFields()),

            HasMany::make('Bookings'),

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
        return [
            ID::make(),
            BelongsTo::make('Created By', 'creator', app('user'))->exceptOnForms(),
            DateTime::make('Created At')->exceptOnForms(),
            BelongsTo::make('Updated By', 'updater', app('user'))->exceptOnForms(),
            DateTime::make('Updated At')->exceptOnForms(),
        ];
    }

    public function cards(Request $request)
    {
        return [];
    }

    public function filters(Request $request)
    {
        return [];
    }

    public function lenses(Request $request)
    {
        return [];
    }

    public function actions(Request $request)
    {
        return [];
    }
}
