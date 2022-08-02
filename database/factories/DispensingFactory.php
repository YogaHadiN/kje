<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Dispensing;

class DispensingFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = Dispensing::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'tanggal' => $this->faker->date(),
            'keluar' => $this->faker->randomNumber(),
            'masuk' => $this->faker->randomNumber(),
            'dispensable_id' => $this->faker->word,
            'dispensable_type' => $this->faker->word,
            'merek_id' => \App\Models\Merek::factory(),
            'tenant_id' => \App\Models\Tenant::factory(),
        ];
    }
}
