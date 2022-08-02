<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\GoPay;

class GoPayFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = GoPay::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'nilai' => $this->faker->randomNumber(),
            'menambah' => $this->faker->randomNumber(),
            'pengeluaran_id' => \App\Models\Pengeluaran::factory(),
            'tenant_id' => \App\Models\Tenant::factory(),
        ];
    }
}
