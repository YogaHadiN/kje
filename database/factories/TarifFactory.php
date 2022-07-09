<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Tarif;

class TarifFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = Tarif::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'jenis_tarif_id' => \App\Models\JenisTarif::factory(),
            'biaya' => $this->faker->randomNumber(),
            'asuransi_id' => \App\Models\Asuransi::factory(),
            'jasa_dokter' => $this->faker->randomNumber(),
            'tipe_tindakan_id' => \App\Models\TipeTindakan::factory(),
            'bhp_items' => $this->faker->text,
            'jasa_dokter_tanpa_sip' => $this->faker->randomNumber(),
            'tenant_id' => \App\Models\Tenant::factory(),
        ];
    }
}
