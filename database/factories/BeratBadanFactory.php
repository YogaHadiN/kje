<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\BeratBadan;

class BeratBadanFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = BeratBadan::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'berat_badan' => $this->faker->word,
            'bb_min' => $this->faker->randomNumber(),
            'bb_max' => $this->faker->randomNumber(),
        ];
    }
}
