<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Icd10;

class Icd10Factory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = Icd10::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'id' => $this->faker->asciify('********************'),
            'diagnosaICD' => $this->faker->word,
            'admedika' => $this->faker->word,
            'terapis' => $this->faker->text,
        ];
    }
}
