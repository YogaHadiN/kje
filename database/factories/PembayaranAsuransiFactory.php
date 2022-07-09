<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\PembayaranAsuransi;

class PembayaranAsuransiFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = PembayaranAsuransi::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'asuransi_id' => \App\Models\Asuransi::factory(),
            'mulai' => $this->faker->dateTime(),
            'akhir' => $this->faker->dateTime(),
            'pembayaran' => $this->faker->randomNumber(),
            'tanggal_dibayar' => $this->faker->dateTime(),
            'kas_coa_id' => \App\Models\Coa::factory(),
            'staf_id' => \App\Models\Staf::factory(),
            'nota_jual_id' => $this->faker->word,
            'tenant_id' => \App\Models\Tenant::factory(),
        ];
    }
}
