<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Pembelian;

class PembelianFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = Pembelian::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'merek_id' => \App\Models\Merek::factory(),
            'jumlah' => $this->faker->randomNumber(),
            'harga_beli' => $this->faker->randomNumber(),
            'harga_jual' => $this->faker->randomNumber(),
            'exp_date' => $this->faker->date(),
            'faktur_belanja_id' => \App\Models\FakturBelanja::factory(),
            'harga_naik' => $this->faker->randomNumber(),
            'staf_id' => $this->faker->word,
            'tenant_id' => \App\Models\Tenant::factory(),
        ];
    }
}
