<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\RumahSakit;

class RumahSakitFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = RumahSakit::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'nama' => $this->faker->word,
            'jenis_rumah_sakit' => $this->faker->word,
            'tipe_rumah_sakit' => $this->faker->word,
            'alamat' => $this->faker->word,
            'kode_pos' => $this->faker->word,
            'telepon' => $this->faker->word,
            'fax' => $this->faker->word,
            'email' => $this->faker->safeEmail,
            'website' => $this->faker->word,
            'rayon_id' => $this->faker->randomNumber(),
            'bpjs' => $this->faker->randomNumber(),
            'ugd' => $this->faker->word,
            'tenant_id' => \App\Models\Tenant::factory(),
        ];
    }
}
