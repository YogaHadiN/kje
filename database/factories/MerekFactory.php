<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Tenant;

class MerekFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'merek'           => $this->faker->name,
            'rak_id'          => \App\Models\Rak::factory(),
            'discontinue'     => rand(0,1),
            'tenant_id'       => Tenant::factory()
        ];
    }
}
