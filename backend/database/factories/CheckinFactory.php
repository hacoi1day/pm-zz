<?php

namespace Database\Factories;

use App\Models\Checkin;
use Illuminate\Database\Eloquent\Factories\Factory;

class CheckinFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Checkin::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => 1,
            'date' => $this->faker->date,
            'time_in' => $this->faker->dateTime,
            'time_out' => null
        ];
    }
}
