<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Pengeluaran;

class PengeluaranFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = Pengeluaran::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'staf_id' => $this->faker->word,
            'keterangan' => $this->faker->word,
            'nilai' => $this->faker->randomNumber(),
            'supplier_id' => \App\Models\Supplier::factory(),
            'tanggal' => $this->faker->dateTime(),
            'sumber_uang_id' => \App\Models\Coa::factory(),
            'faktur_image' => $this->faker->word,
            'tenant_id' => \App\Models\Tenant::factory(),
        ];
    }
}
