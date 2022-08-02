<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\SmsJangan;

class SmsJanganFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = SmsJangan::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'pasien_id' => $this->faker->word,
            'tenant_id' => \App\Models\Tenant::factory(),
        ];
    }
}
