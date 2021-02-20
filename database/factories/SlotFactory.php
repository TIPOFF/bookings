<?php 

declare(strict_types=1);

namespace Tipoff\Bookings\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;
use Tipoff\Bookings\Models\Slot;

class SlotFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Slot::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $startingDate = $this->faker->dateTimeBetween('now', '+5 days');
        $room = randomOrCreate(app('room'));
        // Allows half to default to the room rate and half to ovveride the rate
        if ($this->faker->boolean) {
            $rate = randomOrCreate(app('rate'));
        } else {
            $rate = null;
        }

        $schedule = randomOrCreate(app('recurring_schedule'));
        $dates = [];
        $days = [];
        $initialDate = $schedule->valid_from;
        for ($i = 1; $i < 60; $i++) {
            $date = $initialDate->addDays(1);
            if ($schedule->matchDate($date)) {
                $dates[] = $date;
            }
        }
        $startAt = $dates[array_rand($dates)]->toDateString() . ' ' . rand(10, 20) . ':00:00';
        $type = 'recurring_schedules';

        $startAt = Carbon::parse($startAt);
        $endAt = $startAt->addMinutes(60);

        return [
            'room_id'           => $room,
            'schedule_type'     => $type,
            'schedule_id'       => $schedule->id,
            'rate_id'           => $rate,
            'supervision_id'    => randomOrCreate(app('supervision')),
            'start_at'          => $startAt,
            'end_at'            => $endAt,
        ];
    }
}
