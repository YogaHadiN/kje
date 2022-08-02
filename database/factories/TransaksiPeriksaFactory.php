<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\TransaksiPeriksa;

class TransaksiPeriksaFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = TransaksiPeriksa::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'periksa_id' => \App\Models\Periksa::factory(),
            'jenis_tarif_id' => \App\Models\JenisTarif::factory(),
            'biaya' => $this->faker->randomNumber(),
            'asisten_tindakan_id' => $this->faker->word,
            'keterangan_pemeriksaan' => $this->faker->word,
            'tenant_id' => \App\Models\Tenant::factory(),
        ];
    }
}
