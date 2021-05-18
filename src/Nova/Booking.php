<?php

namespace Tipoff\Bookings\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphTo;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;
use Tipoff\Support\Nova\BaseResource;

class Booking extends BaseResource
{
    public static $model = \Tipoff\Bookings\Models\Booking::class;

    public static $title = 'id';

    public static $search = [
        'id',
    ];

    /** @psalm-suppress UndefinedClass */
    protected array $filterClassList = [
        \Tipoff\Bookings\Nova\Filters\RealizedBookings::class,
        \Tipoff\Scheduler\Nova\Filters\SlotRoom::class,
        \Tipoff\Scheduler\Nova\Filters\SlotDayFilter::class,
    ];

    public static function indexQuery(NovaRequest $request, $query)
    {
        if ($request->user()->hasPermissionTo('all locations')) {
            return $query;
            //neither Slot nor rooms exist in the database
            //->leftJoin('slots as slot', 'slot.id', '=', 'bookings.slot_id')
            //->leftJoin('rooms as room', 'room.id', '=', 'slot.room_id');
        }

        return $query->whereIn('location_id', $request->user()->locations->pluck('id'));
        //neither Slot nor rooms exist in the database
        #->leftJoin('slots as slot', 'slot.id', '=', 'bookings.slot_id')
        #->leftJoin('rooms as room', 'room.id', '=', 'slot.room_id');
    }

    public static $group = 'Operations';

    public function fieldsForIndex(NovaRequest $request)
    {
        return array_filter([
            ID::make()->sortable(),

            Text::make('Slot Number')->sortable(),

            Number::make('Total Participants')->sortable(),

            MorphTo::make('Experience')->types([
                nova('escaperoom_game')
            ]),

            MorphTo::make('Subject')->types([
                nova('room')
            ]),

            MorphTo::make('Agent')->types([
                nova('user')
            ]),
        ]);
    }

    public function fields(Request $request)
    {
        return array_filter([
            Text::make('Slot Number')
                ->rules('required')
                ->sortable(),

            nova('user') ? BelongsTo::make('User', 'user', nova('user'))->sortable() : null,

            nova('location') ? BelongsTo::make('Location', 'location', nova('location'))->sortable() : null,

            Number::make('Total Participants')->rules(['required', 'integer', 'min:1']),

            new Panel('Cost', $this->costFields()),

            MorphTo::make('Experience')->types([
                nova('escaperoom_game')
            ]),

            MorphTo::make('Subject')->types([
                nova('room')
            ]),

            MorphTo::make('Agent')->types([
                nova('user')
            ]),

            nova('rate') ? BelongsTo::make('Rate', 'rate', nova('rate')) : null,

            nova('booking_category') ? BelongsTo::make('Booking Category', 'bookingCategory', nova('booking_category')) : null,

            Date::make('Processed At')->rules('required'),

            Date::make('Canceled At'),

            new Panel('Data Fields', $this->dataFields()),
        ]);
    }

    protected function costFields()
    {
        return array_filter([
            Currency::make('Total Amount')->asMinorUnits()->rules('required'),
            Currency::make('Amount')->asMinorUnits()->rules('required'),
            Currency::make('Taxes', 'total_taxes')->asMinorUnits()->rules('required'),
            Currency::make('Fees', 'total_fees')->asMinorUnits()->rules('required'),
        ]);
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
