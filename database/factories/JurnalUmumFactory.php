<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\JurnalUmum;

class JurnalUmumFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = JurnalUmum::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'jurnalable_id' => $this->faker->word,
            'debit' => $this->faker->randomNumber(),
            'nilai' => $this->faker->randomNumber(),
            'coa_id' => \App\Models\Coa::factory(),
            'jurnalable_type' => $this->faker->word,
            'tenant_id' => \App\Models\Tenant::factory(),
        ];
    }
}
