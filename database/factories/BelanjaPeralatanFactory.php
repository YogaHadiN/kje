<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\BelanjaPeralatan;

class BelanjaPeralatanFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = BelanjaPeralatan::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'peralatan' => $this->faker->word,
            'harga_satuan' => $this->faker->randomNumber(),
            'faktur_belanja_id' => \App\Models\FakturBelanja::factory(),
            'masa_pakai' => $this->faker->randomNumber(),
            'jumlah' => $this->faker->randomNumber(),
            'tenant_id' => \App\Models\Tenant::factory(),
        ];
    }
}
