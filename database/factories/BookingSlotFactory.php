<?php

declare(strict_types=1);

namespace Tipoff\Bookings\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Tipoff\Bookings\Models\BookingSlot;

class BookingSlotFactory extends Factory
{
    protected $model = BookingSlot::class;

    public function definition()
    {
        return [
            'slot_number'            => $this->faker->numberBetween(0, 10),
            'room_id'                => randomOrCreate(app('room')),
            'rate_id'                => randomOrCreate(app('rate')),
            'date'                   => $this->faker->dateTimeBetween('+0 days', '+2 years'),
            'start_at'               => $this->faker->dateTimeBetween('+0 days', '+2 years'),
            'end_at'                 => $this->faker->dateTimeBetween('+0 days', '+2 years'),
            'room_available_at'      => $this->faker->dateTimeBetween('+0 days', '+2 years'),
            'participants'           => $this->faker->numberBetween(1, 255),
            'participants_blocked'   => $this->faker->numberBetween(1, 255),
            'participants_available' => $this->faker->numberBetween(1, 255),
            'supervision_id'         => randomOrCreate(app('supervision')),
            'updater_id'             => randomOrCreate(app('user')),
        ];
    }
}
