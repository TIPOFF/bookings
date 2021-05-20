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
            'slot_number'         => $this->faker->numberBetween(0, 10),
            'user_id'             => randomOrCreate(app('user')),
            'location_id'         => randomOrCreate(app('location')),
            'total_participants'  => $this->faker->numberBetween(0, 10),
            'total_amount'        => $this->faker->numberBetween(0, 10),
            'amount'              => $this->faker->numberBetween(0, 10),
            'total_taxes'         => $this->faker->numberBetween(0, 10),
            'total_fees'          => $this->faker->numberBetween(0, 10),
            'booking_category_id' => randomOrCreate(app('booking_category')),
            'rate_id'             => randomOrCreate(app('rate')),
            'agent_id'            => randomOrCreate(app('user')),
            'agent_type'          => get_class(app('user')),
            'subject_type'        => 'subject',
            'subject_id'          => 1,
            'experience_type'     => 'experience',
            'experience_id'       => 1,
            'processed_at'        => $this->faker->dateTimeBetween('+0 days', '+2 years'),
            'canceled_at'         => null,
            'creator_id'          => randomOrCreate(app('user')),
            'updater_id'          => randomOrCreate(app('user')),
        ];
    }

    /**
     * Set booking subject model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function subject($subject)
    {
        return $this->state(function (array $attributes) use ($subject) {
            $subjectModel = app($subject);

            return [
                'subject_id'   => $subjectModel->id,
                'subject_type' => get_class($subjectModel),
            ];
        });
    }

    /**
     * Set booking experience model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function experience($experience)
    {
        return $this->state(function (array $attributes) use ($experience) {
            $experienceModel = app($experience);

            return [
                'experience_id'   => $experienceModel->id,
                'experience_type' => get_class($experienceModel),
            ];
        });
    }

    /**
     * Use fake experience.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function fakeExperience()
    {
        return $this->state(function (array $attributes) {
            return [
                'experience_id'   => 1,
                'experience_type' => 'experience',
            ];
        });
    }


}
