<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Alergi;

class AlergiFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = Alergi::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'pasien_id' => $this->faker->word,
            'generik_id' => \App\Models\Generik::factory(),
            'tenant_id' => \App\Models\Tenant::factory(),
        ];
    }
}
