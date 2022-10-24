<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TenantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'address_line1' => $this->faker->address,
            'address_line2' => $this->faker->address,
            'address_line3' => $this->faker->address,
        ];
    }
}
