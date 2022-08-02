<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\FacebookDaftar;

class FacebookDaftarFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = FacebookDaftar::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'pasien_id' => $this->faker->word,
            'nama_pasien' => $this->faker->word,
            'tanggal_lahir_pasien' => $this->faker->dateTime(),
            'alamat_pasien' => $this->faker->word,
            'no_hp_pasien' => $this->faker->word,
            'email_pasien' => $this->faker->word,
            'gender_id' => $this->faker->word,
            'facebook_id' => $this->faker->word,
            'pilihan_poli' => \App\Models\Poli::factory(),
            'pilihan_pembayaran' => $this->faker->randomNumber(),
            'verified' => $this->faker->randomNumber(),
            'pernah_berobat' => $this->faker->randomNumber(),
            'tenant_id' => \App\Models\Tenant::factory(),
        ];
    }
}
