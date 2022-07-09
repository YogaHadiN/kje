<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Dose;

class DoseFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = Dose::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'berat_badan_id' => \App\Models\BeratBadan::factory(),
            'signa_id' => \App\Models\Signa::factory(),
            'formula_id' => \App\Models\Formula::factory(),
            'jumlah' => $this->faker->randomNumber(),
            'jumlah_bpjs' => $this->faker->randomNumber(),
            'jumlah_puyer_add' => $this->faker->randomNumber(),
            'tenant_id' => \App\Models\Tenant::factory(),
        ];
    }
}
