<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\CekPulsa;

class CekPulsaFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = CekPulsa::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'staf_id' => \App\Models\Staf::factory(),
            'pulsa_zenziva' => $this->faker->randomNumber(),
            'pulsa_gammu' => $this->faker->randomNumber(),
            'expired_zenziva' => $this->faker->dateTime(),
            'expired_gammu' => $this->faker->dateTime(),
            'tenant_id' => \App\Models\Tenant::factory(),
        ];
    }
}
