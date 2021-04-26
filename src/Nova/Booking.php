<?php

namespace Tipoff\Bookings\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphMany;
use Laravel\Nova\Fields\MorphOne;
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
            Text::make('Room', 'room.id', function () {
                return $this->room->name;
            })->sortable(),
            Text::make('Game Start', 'slot.start_at', function () {
                return $this->slot->formatted_start;
            })->sortable(),
            Date::make('Game Date', 'slot.date')->sortable(),
            Number::make('Participants'),
            DateTime::make('Purchased', 'created_at')->sortable(),
        ]);
    }

    public function fields(Request $request)
    {
        return array_filter([
            nova('slot') ? BelongsTo::make('Slot', 'slot', nova('slot')) : null,
            Text::make('Game Start', 'slot.start_at', function () {
                return $this->slot->formatted_start;
            })->exceptOnForms(),
            Number::make('Participants')->exceptOnForms(),
            Boolean::make('Private Game?', 'is_private')->exceptOnForms(),

            new Panel('Customer', $this->customerFields()),
            new Panel('Cost', $this->costFields()),

            nova('signature') ? HasMany::make('Signatures', 'signatures', nova('signature')) : null,
            nova('note') ? MorphMany::make('Notes', 'notes', nova('note')) : null,

            new Panel('Data Fields', $this->dataFields()),
        ]);
    }

    protected function customerFields()
    {
        return [
            Text::make('Name', 'user.full_name')->exceptOnForms(),
            /**
             * TODO - if address fields are important for bookings, then booking should be Addressable itself.
             * It should not rely on an order item/order existing since those packages may not be installed!!
            Text::make('Address', '...')->exceptOnForms(),
            Text::make('City', '...')->exceptOnForms(),
            Text::make('State', '...')->exceptOnForms(),
            Number::make('Zip', '...')->exceptOnForms(),
            */
        ];
    }

    protected function costFields()
    {
        return array_filter([
            nova('order_item') ? MorphOne::make('Order Item', 'sellable', nova('order_item'))->hideWhenUpdating()->exceptOnForms() : null,
            nova('rate') ? BelongsTo::make('Rate', 'rate', nova('rate'))->nullable()->exceptOnForms() : null,
            nova('tax') ? BelongsTo::make('Tax', 'tax', nova('tax'))->nullable()->exceptOnForms() : null,
            nova('fee') ? BelongsTo::make('Fee', 'fee', nova('fee'))->nullable()->exceptOnForms() : null,
            Currency::make('Amount')->asMinorUnits()->exceptOnForms(),
            Currency::make('Taxes', 'total_taxes')->asMinorUnits()->exceptOnForms(),
            Currency::make('Fees', 'total_fees')->asMinorUnits()->exceptOnForms(),
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
