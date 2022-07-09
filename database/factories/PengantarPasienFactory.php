<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\PengantarPasien;

class PengantarPasienFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = PengantarPasien::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'pengantar_id' => \App\Models\Pasien::factory(),
            'antarable_id' => $this->faker->word,
            'antarable_type' => $this->faker->word,
            'kunjungan_sehat' => $this->faker->word,
            'pcare_submit' => $this->faker->randomNumber(),
            'tenant_id' => \App\Models\Tenant::factory(),
        ];
    }
}
