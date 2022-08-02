<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\KeteranganPenyusutan;

class KeteranganPenyusutanFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = KeteranganPenyusutan::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'keterangan' => $this->faker->text,
            'golongan_peralatan_id' => \App\Models\GolonganPeralatan::factory(),
            'tenant_id' => \App\Models\Tenant::factory(),
        ];
    }
}
