<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\RegisterHamil;

class RegisterHamilFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = RegisterHamil::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'pasien_id' => \App\Models\Pasien::factory(),
            'nama_suami' => $this->faker->word,
            'tb' => $this->faker->randomNumber(),
            'buku_id' => \App\Models\Buku::factory(),
            'golongan_darah' => $this->faker->word,
            'tinggi_badan' => $this->faker->randomNumber(),
            'tanggal_lahir_anak_terakhir' => $this->faker->date(),
            'bb_sebelum_hamil' => $this->faker->randomNumber(),
            'g' => $this->faker->randomNumber(),
            'p' => $this->faker->randomNumber(),
            'a' => $this->faker->randomNumber(),
            'status_imunisasi_tt_id' => $this->faker->randomNumber(),
            'riwayat_persalinan_sebelumnya' => $this->faker->text,
            'jumlah_janin' => $this->faker->randomNumber(),
            'hpht' => $this->faker->date(),
            'rencana_penolong' => $this->faker->word,
            'rencana_tempat' => $this->faker->word,
            'rencana_pendamping' => $this->faker->word,
            'rencana_transportasi' => $this->faker->word,
            'rencana_pendonor' => $this->faker->word,
            'tenant_id' => \App\Models\Tenant::factory(),
        ];
    }
}
