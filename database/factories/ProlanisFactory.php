<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Prolanis;

class ProlanisFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = Prolanis::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'nama' => $this->faker->word,
            'jenis_kelamin' => $this->faker->word,
            'usia' => $this->faker->word,
            'alamat' => $this->faker->word,
            'no' => $this->faker->word,
            'prolanis' => $this->faker->word,
            'periode' => $this->faker->date(),
            'tenant_id' => \App\Models\Tenant::factory(),
        ];
    }
}
