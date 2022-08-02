<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\BukanObat;

class BukanObatFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = BukanObat::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'nama' => $this->faker->word,
            'jenis_pengeluaran_id' => $this->faker->randomNumber(),
            'harga_beli' => $this->faker->randomNumber(),
            'coa_id' => $this->faker->word,
            'tenant_id' => \App\Models\Tenant::factory(),
        ];
    }
}
