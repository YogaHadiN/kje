<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\GolonganPeralatan;

class GolonganPeralatanFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = GolonganPeralatan::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'golongan_peralatan' => $this->faker->word,
            'masa_pakai' => $this->faker->randomNumber(),
            'keterangan' => $this->faker->word,
        ];
    }
}
