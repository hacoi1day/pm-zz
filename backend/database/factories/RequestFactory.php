<?php

namespace Database\Factories;

use App\Models\Request;
use Illuminate\Database\Eloquent\Factories\Factory;

class RequestFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Request::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => 1,
            'type' => 1,
            'start' => $this->faker->dateTime,
            'end' => $this->faker->dateTime,
            'phone' => $this->faker->phoneNumber,
            'cause' => $this->faker->jobTitle,
            'project' => $this->faker->catchPhrase,
            'approval_by' => null,
            'status' => null
        ];
    }
}
