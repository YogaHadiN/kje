<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\DenominatorBpjs;

class DenominatorBpjsFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = DenominatorBpjs::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'bulanTahun' => $this->faker->dateTime(),
            'jumlah_peserta' => $this->faker->randomNumber(),
            'denominator_dm' => $this->faker->randomNumber(),
            'denominator_ht' => $this->faker->randomNumber(),
            'tenant_id' => \App\Models\Tenant::factory(),
        ];
    }
}
