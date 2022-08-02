<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Coa;

class CoaFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = Coa::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'kelompok_coa_id' => \App\Models\KelompokCoa::factory(),
            'coa' => $this->faker->word,
            'saldo_awal' => $this->faker->randomNumber(),
            'tenant_id' => \App\Models\Tenant::factory(),
            'kode_coa' => $this->faker->word,
        ];
    }
}
