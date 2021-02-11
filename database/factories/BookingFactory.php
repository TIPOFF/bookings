<?php namespace Tipoff\Bookings\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Tipoff\Bookings\Models\Booking;

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
            'order_id'     => randomOrCreate(app('order')),
            // @todo need to limit slots to just the ones for a room at the location of the order.
            'slot_id'      => randomOrCreate(app('slot')),
            'participants' => $this->faker->numberBetween(1, 10),
            'is_private'   => $this->faker->boolean,
        ];
    }
}
