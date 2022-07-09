<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\BayarGaji;

class BayarGajiFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = BayarGaji::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'staf_id' => \App\Models\Staf::factory(),
            'mulai' => $this->faker->dateTime(),
            'akhir' => $this->faker->dateTime(),
            'gaji_pokok' => $this->faker->randomNumber(),
            'bonus' => $this->faker->randomNumber(),
            'tanggal_dibayar' => $this->faker->dateTime(),
            'sumber_uang_id' => \App\Models\Coa::factory(),
            'hutang' => $this->faker->randomNumber(),
            'petugas_id' => $this->faker->word,
            'tenant_id' => \App\Models\Tenant::factory(),
        ];
    }
}
