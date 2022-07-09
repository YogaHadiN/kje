<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\GajiGigi;

class GajiGigiFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = GajiGigi::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'staf_id' => \App\Models\Staf::factory(),
            'petugas_id' => \App\Models\Staf::factory(),
            'tenant_id' => \App\Models\Tenant::factory(),
        ];
    }
}
