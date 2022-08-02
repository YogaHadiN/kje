<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\DiscountAsuransi;

class DiscountAsuransiFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = DiscountAsuransi::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'discount_id' => \App\Models\Discount::factory(),
            'asuransi_id' => \App\Models\Asuransi::factory(),
            'tenant_id' => \App\Models\Tenant::factory(),
        ];
    }
}
