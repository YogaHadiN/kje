<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\JenisAntrian;

class JenisAntrianFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = JenisAntrian::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'jenis_antrian' => $this->faker->word,
            'prefix' => $this->faker->word,
            'antrian_terakhir_id' => null, 
        ];
    }
}
