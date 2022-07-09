<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\AntrianPoli;

class AntrianPoliFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = AntrianPoli::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'pasien_id' => \App\Models\Pasien::factory(),
            'asuransi_id' => \App\Models\Asuransi::factory(),
            'poli_id' => $this->faker->randomNumber(),
            'staf_id' => \App\Models\Staf::factory(),
            'tanggal' => $this->faker->dateTime(),
            'jam' => $this->faker->time(),
            'kecelakaan_kerja' => $this->faker->randomNumber(),
            'self_register' => $this->faker->randomNumber(),
            'bukan_peserta' => $this->faker->randomNumber(),
            'submitted' => $this->faker->boolean,
            'tenant_id' => \App\Models\Tenant::factory(),
        ];
    }
}
