<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Point;

class PointFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = Point::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'periksa_id' => $this->faker->word,
            'suhu' => $this->faker->word,
            'tinggi_badan' => $this->faker->randomNumber(),
            'berat_badan' => $this->faker->randomNumber(),
            'tekanan_darah' => $this->faker->word,
            'tenant_id' => \App\Models\Tenant::factory(),
        ];
    }
}
