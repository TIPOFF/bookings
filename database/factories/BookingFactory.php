<?php

declare(strict_types=1);

namespace Tipoff\Bookings\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Tipoff\Bookings\Models\Booking;
use Tipoff\Bookings\Models\BookingCategory;
use Tipoff\Bookings\Models\Rate;

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
            'booking_category_id'   => randomOrCreate(app('booking_category')),
            'rate_id'               => randomOrCreate(app('rate')),
            'experience_id'         => $this->faker->numberBetween(0, 10),
            'experience_type'       => 'Game',
            'order_id'              => $this->faker->numberBetween(0, 10),
            'order_type'            => 'Order',
            'booking_status_id'     => '1',
            'agent_id'              => $this->faker->numberBetween(0, 10),
            'agent_type'            => 'Agent',
            'user_id'               => $this->faker->numberBetween(0, 10),
            'user_type'             => 'User',
            'subject_id'            => $this->faker->numberBetween(0, 10),
            'subject_type'          => 'Subject',        
            'proccessed_at'         => $this->faker->dateTimeBetween('+0 days', '+2 years'),        
            'canceled_at'           => $this->faker->dateTimeBetween('+0 days', '+2 years'),        
        ];
    }
}
