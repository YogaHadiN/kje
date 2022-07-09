<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\FakturBelanja;

class FakturBelanjaFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = FakturBelanja::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'tanggal' => $this->faker->dateTime(),
            'supplier_id' => \App\Models\Supplier::factory(),
            'submit' => $this->faker->boolean,
            'nomor_faktur' => $this->faker->word,
            'belanja_id' => \App\Models\Belanja::factory(),
            'sumber_uang_id' => \App\Models\Coa::factory(),
            'faktur_image' => $this->faker->word,
            'petugas_id' => \App\Models\Staf::factory(),
            'diskon' => $this->faker->randomNumber(),
            'tenant_id' => \App\Models\Tenant::factory(),
        ];
    }
}
