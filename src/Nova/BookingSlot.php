<?php

namespace Tipoff\Bookings\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphMany;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;
use Tipoff\EscapeRoom\Nova\Filters\Room;
use Tipoff\EscapeRoom\Nova\Filters\RoomLocation;
use Tipoff\Scheduler\Nova\Filters\FutureSlots;
use Tipoff\Support\Nova\BaseResource;

class BookingSlot extends BaseResource
{
    public static $model = \Tipoff\Bookings\Models\BookingSlot::class;

    public static $title = 'slot_number';

    public static $search = [
        'start_at',
    ];

    /** @psalm-suppress UndefinedClass */
    protected array $filterClassList = [
        FutureSlots::class,
        RoomLocation::class,
        Room::class,
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
                ->select('booking_slots.*')
                ->leftJoin('rooms as room', 'room.id', '=', 'booking_slots.room_id');
        }

        return $query->whereHas('room', function ($roomlocation) use ($request) {
            return $roomlocation
                ->whereIn('location_id', $request->user()->locations->pluck('id'));
        })->select('booking_slots.*')
            ->leftJoin('rooms as room', 'room.id', '=', 'booking_slots.room_id');
    }

    public static $group = 'Operations Scheduling';

    public static $defaultAttributes = [
        'supervision_id' => 2,
    ];

    public function fieldsForIndex(NovaRequest $request)
    {
        return array_filter([
            ID::make()->sortable(),
            nova('room') ? BelongsTo::make('Room', 'room', nova('room'))->sortable() : null,
            Text::make('Start', 'start_at', function () {
                return $this->formatted_start;
            })->sortable(),
            Date::make('Date', 'date')->sortable(),
            Number::make('Participants'),
            Number::make('Available', 'participants_available'),
        ]);
    }

    public function fields(Request $request)
    {
        return array_filter([
            Text::make('Title')->exceptOnForms(),
            Text::make('Game Start', 'start_at', function () {
                return $this->formatted_start;
            })->exceptOnForms(),
            Text::make('Slot Number')->required(),
            DateTime::make('Start At')->required(),
            nova('rate') ? BelongsTo::make('Rate') : null,
            nova('supervision') ? BelongsTo::make('Supervision', 'supervision', nova('supervision'))->hideWhenCreating()->nullable() : null,
            new Panel('Participant Details', $this->participantFields()),
            nova('booking') ? HasMany::make('Bookings', 'bookings', nova('booking')) : null,
            nova('block') ? HasMany::make('Blocks', 'blocks', nova('block')) : null,
            nova('note') ? MorphMany::make('Notes', 'notes', nova('note')) : null,
            nova('game') ? HasOne::make('Game', 'game', nova('game'))->nullable()->exceptOnForms() : null,
            nova('room') ? BelongsTo::make('Room', 'room', nova('room')) : null,

            new Panel('Data Fields', $this->dataFields()),
        ]);
    }

    protected function participantFields()
    {
        return array_filter([
            Number::make('Participants')->rules('required', 'numeric', 'digits_between:1,3'),
            Number::make('Participants Blocked')->rules('required', 'numeric', 'digits_between:1,3'),
            Number::make('Participants Available')->rules('required', 'numeric', 'digits_between:1,3'),
            Date::make('Date')->required(),
            DateTime::make('End At')->required(),
            DateTime::make('Room Available At')->required(),
        ]);
    }

    protected function dataFields(): array
    {
        return array_merge(parent::dataFields(), [
            Text::make('Slot Number')->exceptOnForms(),
            DateTime::make('Created At')->exceptOnForms(),
            BelongsTo::make('Updated By', 'updater', nova('user'))->exceptOnForms(),
            DateTime::make('Updated At')->exceptOnForms(),
        ]);
    }
}
