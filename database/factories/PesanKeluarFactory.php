<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\PesanKeluar;

class PesanKeluarFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = PesanKeluar::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'periksa_id' => \App\Models\Periksa::factory(),
            'pesan' => $this->faker->word,
            'outbox_id' => $this->faker->word,
            'sudah_diproses' => $this->faker->randomNumber(),
            'tenant_id' => \App\Models\Tenant::factory(),
        ];
    }
}
