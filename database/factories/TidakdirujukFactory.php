<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Tidakdirujuk;

class TidakdirujukFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = Tidakdirujuk::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'icd10_id' => \App\Models\Icd10::factory(),
            'diagnosa' => $this->faker->word,
        ];
    }
}
