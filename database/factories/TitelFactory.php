<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TitelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'titel'     => $this->faker->word,
            'singkatan' => $this->faker->word,
        ];
    }
}
