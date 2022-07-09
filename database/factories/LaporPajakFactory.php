<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\LaporPajak;

class LaporPajakFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = LaporPajak::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'tanggal_lapor' => $this->faker->date(),
            'awal_periode' => $this->faker->date(),
            'akhir_periode' => $this->faker->date(),
            'staf_id' => $this->faker->word,
            'jenis_pajak_id' => $this->faker->word,
            'dokumen_dan_bukti' => $this->faker->word,
            'nilai' => $this->faker->randomNumber(),
            'tenant_id' => \App\Models\Tenant::factory(),
        ];
    }
}
