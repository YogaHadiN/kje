<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Komposisi;

class KomposisiFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = Komposisi::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'generik_id' => \App\Models\Generik::factory(),
            'bobot' => $this->faker->word,
            'formula_id' => \App\Models\Formula::factory(),
            'tenant_id' => \App\Models\Tenant::factory(),
        ];
    }
}
