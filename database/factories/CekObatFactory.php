<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\CekObat;

class CekObatFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = CekObat::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'rak_id' => \App\Models\Rak::factory(),
            'staf_id' => \App\Models\Staf::factory(),
            'jumlah_di_sistem' => $this->faker->randomNumber(),
            'jumlah_di_hitung' => $this->faker->randomNumber(),
            'tenant_id' => \App\Models\Tenant::factory(),
        ];
    }
}
