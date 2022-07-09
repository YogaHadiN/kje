<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Discount;

class DiscountFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = Discount::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'jenis_tarif_id' => \App\Models\JenisTarif::factory(),
            'diskon_persen' => $this->faker->randomNumber(),
            'dimulai' => $this->faker->dateTime(),
            'berakhir' => $this->faker->dateTime(),
            'tenant_id' => \App\Models\Tenant::factory(),
        ];
    }
}
