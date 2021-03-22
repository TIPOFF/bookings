<?php

declare(strict_types=1);

namespace Tipoff\Bookings\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Tipoff\Bookings\Models\Booking;
use Tipoff\Bookings\Models\BookingCategory;
use Tipoff\Bookings\Models\Rate;

class BookingFactory extends Factory
{
    protected $model = Booking::class;

    public function definition()
    {
        return [
            'slot_number'           => $this->faker->numberBetween(0, 10),
            'user_id'               => randomOrCreate(app('user')),
            'order_id'              => randomOrCreate(app('order')),
            'total_participants'    => $this->faker->numberBetween(0, 10),
            'total_amount'          => $this->faker->numberBetween(0, 10),
            'amount'                => $this->faker->numberBetween(0, 10),
            'total_taxes'           => $this->faker->numberBetween(0, 10),
            'total_fees'            => $this->faker->numberBetween(0, 10),
            'booking_category_id'   => randomOrCreate(app('booking_category')),
            'rate_id'               => randomOrCreate(app('rate')),
            'experience_id'         => $this->faker->numberBetween(0, 10),
            'experience_type'       => 'EscaperoomSlot',
            'agent_id'              => $this->faker->numberBetween(0, 10),
            'agent_type'            => 'Agent',
            'subject_id'            => $this->faker->numberBetween(0, 10),
            'subject_type'          => 'Room',        
            'proccessed_at'         => $this->faker->dateTimeBetween('+0 days', '+2 years'),        
            'canceled_at'           => $this->faker->dateTimeBetween('+0 days', '+2 years'),        
        ];
    }
}
