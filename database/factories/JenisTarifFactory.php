<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\JenisTarif;
use App\Models\TipeJenisTarif;

class JenisTarifFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = JenisTarif::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'jenis_tarif'              => $this->faker->word,
            'tipe_jenis_tarif_id'      => TipeJenisTarif::factory(),
            'tipe_laporan_admedika_id' => $this->faker->randomNumber(),
            'tipe_laporan_kasir_id'    => $this->faker->randomNumber(),
            'coa_id'                   => $this->faker->randomNumber(),
            'dengan_asisten'           => rand(0,1),
            'murni_jasa_dokter'        => $this->faker->randomNumber(),
            'tenant_id'                => \App\Models\Tenant::factory(),
        ];
    }
}
