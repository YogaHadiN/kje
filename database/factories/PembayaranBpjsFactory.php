<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\PembayaranBpjs;

class PembayaranBpjsFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = PembayaranBpjs::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'staf_id' => \App\Models\Staf::factory(),
            'nilai' => $this->faker->randomNumber(),
            'mulai_tanggal' => $this->faker->dateTime(),
            'akhir_tanggal' => $this->faker->dateTime(),
            'tanggal_pembayaran' => $this->faker->dateTime(),
            'tenant_id' => \App\Models\Tenant::factory(),
        ];
    }
}
