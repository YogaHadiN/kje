<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\PesertaBpjsPerbulan;

class PesertaBpjsPerbulanFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = PesertaBpjsPerbulan::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'nama_file' => $this->faker->word,
            'jumlah_dm' => $this->faker->randomNumber(),
            'jumlah_ht' => $this->faker->randomNumber(),
            'bulanTahun' => $this->faker->dateTime(),
            'tenant_id' => \App\Models\Tenant::factory(),
        ];
    }
}
