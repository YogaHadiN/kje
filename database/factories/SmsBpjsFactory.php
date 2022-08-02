<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\SmsBpjs;

class SmsBpjsFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = SmsBpjs::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'pasien_id' => \App\Models\Pasien::factory(),
            'pesan' => $this->faker->word,
            'callBackUrl' => $this->faker->word,
            'pcare_submit' => $this->faker->randomNumber(),
            'tenant_id' => \App\Models\Tenant::factory(),
            'old_id' => $this->faker->word,
        ];
    }
}
