<?php

namespace Database\Factories;

use App\Models\MapPin;
use Illuminate\Database\Eloquent\Factories\Factory;

class MapPinFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MapPin::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'pin_name' => $this->faker->word,
            'description' => $this->faker->sentence,
            'favourite' => $this->faker->boolean,
            'latitude' => $this->faker->latitude,
            'longitude' => $this->faker->longitude,
            'user_id' => function () {
                // Assuming you have a User model, retrieve a random user ID
                return \App\Models\User::factory()->create()->id;
            },
            'category' => $this->faker->word,
            // Add other attributes as needed
        ];
    }
}
