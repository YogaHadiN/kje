<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\DeletedPeriksa;

class DeletedPeriksaFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = DeletedPeriksa::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'pasien_id' => $this->faker->word,
            'periksa_id' => $this->faker->word,
            'staf_id' => $this->faker->word,
            'kabur_id' => $this->faker->word,
            'tenant_id' => \App\Models\Tenant::factory(),
        ];
    }
}
