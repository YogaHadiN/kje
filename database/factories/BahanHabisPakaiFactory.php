<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\BahanHabisPakai;

class BahanHabisPakaiFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = BahanHabisPakai::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'merek_id' => \App\Models\Merek::factory(),
            'jumlah' => $this->faker->randomNumber(),
            'jenis_tarif_id' => \App\Models\JenisTarif::factory(),
            'tenant_id' => \App\Models\Tenant::factory(),
        ];
    }
}
