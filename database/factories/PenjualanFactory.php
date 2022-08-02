<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Penjualan;

class PenjualanFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = Penjualan::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'merek_id' => \App\Models\Merek::factory(),
            'nota_jual_id' => \App\Models\NotaJual::factory(),
            'harga_jual' => $this->faker->randomNumber(),
            'jumlah' => $this->faker->randomNumber(),
            'tenant_id' => \App\Models\Tenant::factory(),
        ];
    }
}
