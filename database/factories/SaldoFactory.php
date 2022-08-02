<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Saldo;

class SaldoFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = Saldo::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'saldo' => $this->faker->randomNumber(),
            'saldo_saat_ini' => $this->faker->randomNumber(),
            'selisih' => $this->faker->randomNumber(),
            'staf_id' => \App\Models\Staf::factory(),
            'tenant_id' => \App\Models\Tenant::factory(),
        ];
    }
}
