<?php

namespace Tipoff\Bookings\Nova;

use Dniccum\PhoneNumber\PhoneNumber;
use Illuminate\Http\Request;
use Inspheric\Fields\Email;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphMany;
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
        \Tipoff\Locations\Nova\Filters\OrderLocation::class,
    ];

    public static function indexQuery(NovaRequest $request, $query)
    {
        if ($request->user()->hasRole([
            'Admin',
            'Owner',
            'Accountant',
            'Executive',
            'Reservation Manager',
            'Reservationist',
        ])) {
            return $query
                ->select('bookings.*')
                ->leftJoin('slots as slot', 'slot.id', '=', 'bookings.slot_id')
                ->leftJoin('rooms as room', 'room.id', '=', 'slot.room_id');
        }

        return $query->whereHas('order', function ($orderlocation) use ($request) {
            return $orderlocation
                ->whereIn('order.location_id', $request->user()->locations->pluck('id'));
        })->select('bookings.*')
            ->leftJoin('slots as slot', 'slot.id', '=', 'bookings.slot_id')
            ->leftJoin('rooms as room', 'room.id', '=', 'slot.room_id')
            ->leftJoin('orders as order', 'order.id', '=', 'bookings.order_id');
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
            Text::make('Name', 'order.customer.user.full_name')->exceptOnForms(),
            PhoneNumber::make('Phone', 'order.customer.phone_number')->format('###-###-####')->disableValidation()->useMaskPlaceholder()->linkOnDetail()->exceptOnForms(),
            Email::make('Email', 'order.customer.user.email')->clickable()->exceptOnForms(),
            Text::make('Address', 'order.customer.address')->exceptOnForms(),
            Text::make('City', 'order.customer.city')->exceptOnForms(),
            Text::make('State', 'order.customer.state')->exceptOnForms(),
            Number::make('Zip', 'order.customer.zip')->exceptOnForms(),
        ];
    }

    protected function costFields()
    {
        return array_filter([
            nova('order') ? BelongsTo::make('Order', 'order', nova('order'))->hideWhenUpdating()->exceptOnForms() : null,
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
