<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\CheckoutDetail;

class CheckoutDetailFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = CheckoutDetail::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'jumlah' => $this->faker->randomNumber(),
            'checkout_kasir_id' => $this->faker->randomNumber(),
            'nilai' => $this->faker->randomNumber(),
            'coa_id' => \App\Models\Coa::factory(),
            'tenant_id' => \App\Models\Tenant::factory(),
        ];
    }
}
