<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\PenjualanAset;

class PenjualanAsetFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = PenjualanAset::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'harta_id' => $this->faker->word,
            'staf_id' => $this->faker->word,
            'harga_jual' => $this->faker->randomNumber(),
            'harga_beli' => $this->faker->randomNumber(),
            'penyusutan' => $this->faker->randomNumber(),
            'faktur_image' => $this->faker->word,
            'tenant_id' => \App\Models\Tenant::factory(),
        ];
    }
}
