<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Email;

class EmailFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = Email::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'email' => $this->faker->safeEmail,
            'emailable_type' => $this->faker->word,
            'emailable_id' => $this->faker->word,
            'tenant_id' => \App\Models\Tenant::factory(),
        ];
    }
}
