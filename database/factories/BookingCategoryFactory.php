<?php

declare(strict_types=1);

namespace Tipoff\Bookings\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Tipoff\Bookings\Models\BookingCategory;

class BookingCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BookingCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     * @throws \Exception
     */
    public function definition()
    {
        return [
            'label' => $this->faker->text,
            'creator_id' => randomOrCreate(app('user')),
            'updater_id' =>  randomOrCreate(app('user')),
        ];
    }
}
