<?php

declare(strict_types=1);

namespace Tipoff\Bookings\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Tipoff\Bookings\Models\Booking;
use Tipoff\Bookings\Models\BookingCategory;
use Tipoff\Bookings\Models\BookingStatus;

class BookingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Booking::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'slot_number'           => $this->faker->numberBetween(0, 10),
            'total_participants'    => $this->faker->numberBetween(0, 10),
            'total_amount'          => $this->faker->numberBetween(0, 10),
            'amount'                => $this->faker->numberBetween(0, 10),
            'total_taxes'           => $this->faker->numberBetween(0, 10),
            'total_fees'            => $this->faker->numberBetween(0, 10),
            'booking_category_id'   => BookingCategory::factory()->create()->id,
//            'booking_status_id'     => BookingStatus::factory()->create()->id
        ];
    }
}
