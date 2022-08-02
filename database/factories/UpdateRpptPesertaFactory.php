<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\UpdateRpptPeserta;

class UpdateRpptPesertaFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = UpdateRpptPeserta::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'pasien_id' => $this->faker->word,
            'nama_sebelum' => $this->faker->word,
            'nama_sesudah' => $this->faker->word,
            'prolanis' => $this->faker->word,
            'tenant_id' => \App\Models\Tenant::factory(),
        ];
    }
}
