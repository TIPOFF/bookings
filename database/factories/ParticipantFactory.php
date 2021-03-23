<?php

declare(strict_types=1);

namespace Tipoff\Bookings\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Tipoff\Bookings\Models\Participant;

class ParticipantFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Participant::class;

    /**
     * Define the model's default state.
     *
     * @return array
     * @throws \Exception
     */
    public function definition()
    {
        return [
            'email_address_id'      => randomOrCreate(app('email_address')),
            'first_name'            => $this->faker->firstName,
            'last_name'             => $this->faker->lastName,
            'birth_date'            => $this->faker->date('Y-m-d'),
            'is_verified'           => false,
            'user_id'               => randomOrCreate(app('user')),
        ];
    }
}
