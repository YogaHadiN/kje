<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Berkas;

class BerkasFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = Berkas::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'berkasable_id' => $this->faker->word,
            'nama_file' => $this->faker->word,
            'berkasable_type' => $this->faker->word,
            'url' => $this->faker->url,
            'tenant_id' => \App\Models\Tenant::factory(),
        ];
    }
}
