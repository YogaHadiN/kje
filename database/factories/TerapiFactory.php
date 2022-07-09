<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Terapi;

class TerapiFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = Terapi::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'merek_id' => \App\Models\Merek::factory(),
            'signa' => $this->faker->word,
            'aturan_minum' => $this->faker->word,
            'jumlah' => $this->faker->randomNumber(),
            'harga_beli_satuan' => $this->faker->randomNumber(),
            'harga_jual_satuan' => $this->faker->randomNumber(),
            'periksa_id' => \App\Models\Periksa::factory(),
            'tenant_id' => \App\Models\Tenant::factory(),
        ];
    }
}
