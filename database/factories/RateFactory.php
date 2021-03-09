<?php

declare(strict_types=1);

namespace Tipoff\Bookings\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Tipoff\Bookings\Models\Rate;
use Tipoff\Bookings\Models\RateCategory;

class RateFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Rate::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $types = ['public', 'private'];
        return [
            'slug'                  => $this->faker->slug,
            'amount'                => $this->faker->numberBetween(0, 9999),
            'rate_type'             => $types[array_rand($types)],
            'participant_limit'     => $this->faker->numberBetween(0, 100),
            'rate_category_id'      => RateCategory::factory()->create()->id,
            'creator_id'            => randomOrCreate(app('user')),
            'updater_id'            => randomOrCreate(app('user'))
        ];
    }
}
