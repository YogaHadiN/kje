<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\PoliAntrian;

class PoliAntrianFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = PoliAntrian::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'jenis_antrian_id' => $this->faker->word,
            'poli_id' => \App\Models\Poli::factory(),
            'tenant_id' => \App\Models\Tenant::factory(),
        ];
    }
}
