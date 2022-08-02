<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\CekListrik;

class CekListrikFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = CekListrik::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'staf_id' => \App\Models\Staf::factory(),
            'listrik_a6' => $this->faker->randomNumber(),
            'listrik_a7' => $this->faker->randomNumber(),
            'listrik_a8' => $this->faker->randomNumber(),
            'tenant_id' => \App\Models\Tenant::factory(),
        ];
    }
}
