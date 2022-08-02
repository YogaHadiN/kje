<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Generik;

class GenerikFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = Generik::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'generik' => $this->faker->word,
            'pregnancy_safety_index' => $this->faker->word,
            'peroral' => $this->faker->word,
            'parenteral' => $this->faker->word,
            'topical' => $this->faker->word,
            'opthalmic' => $this->faker->word,
            'vaginal' => $this->faker->word,
            'inhalation' => $this->faker->word,
            'lingual' => $this->faker->word,
            'transdermal' => $this->faker->word,
            'nasal' => $this->faker->word,
            'tenant_id' => \App\Models\Tenant::factory(),
        ];
    }
}
