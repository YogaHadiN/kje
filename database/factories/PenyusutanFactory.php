<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Penyusutan;

class PenyusutanFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = Penyusutan::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'keterangan' => $this->faker->word,
            'susutable_id' => $this->faker->randomNumber(),
            'susutable_type' => $this->faker->word,
            'nilai' => $this->faker->randomNumber(),
            'ringkasan_penyusutan_id' => \App\Models\RingkasanPenyusutan::factory(),
            'tenant_id' => \App\Models\Tenant::factory(),
        ];
    }
}
