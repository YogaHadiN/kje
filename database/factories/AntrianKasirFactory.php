<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\AntrianKasir;

class AntrianKasirFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = AntrianKasir::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'periksa_id' => \App\Models\Periksa::factory(),
            'jam' => $this->faker->time(),
            'tanggal' => $this->faker->date(),
            'dipanggil' => $this->faker->boolean,
            'tenant_id' => \App\Models\Tenant::factory(),
        ];
    }
}
