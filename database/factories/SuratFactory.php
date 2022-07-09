<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Surat;

class SuratFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = Surat::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'nomor_surat' => $this->faker->word,
            'tanggal' => $this->faker->dateTime(),
            'surat_masuk' => $this->faker->boolean,
            'alamat' => $this->faker->word,
            'foto_surat' => $this->faker->word,
            'tenant_id' => \App\Models\Tenant::factory(),
        ];
    }
}
