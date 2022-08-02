<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Pendapatan;

class PendapatanFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = Pendapatan::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'keterangan' => $this->faker->word,
            'nilai' => $this->faker->randomNumber(),
            'sumber_uang' => $this->faker->word,
            'staf_id' => \App\Models\Staf::factory(),
            'tenant_id' => \App\Models\Tenant::factory(),
        ];
    }
}
