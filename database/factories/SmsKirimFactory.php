<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\SmsKirim;

class SmsKirimFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = SmsKirim::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'message_id' => $this->faker->word,
            'no_telp' => $this->faker->word,
            'status' => $this->faker->word,
            'delivery_status' => $this->faker->boolean,
            'text' => $this->faker->word,
            'tenant_id' => \App\Models\Tenant::factory(),
        ];
    }
}
