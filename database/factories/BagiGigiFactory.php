<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\BagiGigi;

class BagiGigiFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = BagiGigi::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'petugas_id' => \App\Models\Staf::factory(),
            'nilai' => $this->faker->randomNumber(),
            'tanggal_dibayar' => $this->faker->dateTime(),
            'mulai' => $this->faker->dateTime(),
            'akhir' => $this->faker->dateTime(),
            'tenant_id' => \App\Models\Tenant::factory(),
        ];
    }
}
