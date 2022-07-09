<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\AntrianPeriksa;

class AntrianPeriksaFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = AntrianPeriksa::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'asuransi_id' => \App\Models\Asuransi::factory(),
            'pasien_id' => \App\Models\Pasien::factory(),
            'staf_id' => \App\Models\Staf::factory(),
            'tanggal' => $this->faker->date(),
            'jam' => $this->faker->time(),
            'hamil' => $this->faker->word,
            'menyusui' => $this->faker->randomNumber(),
            'riwayat_alergi_obat' => $this->faker->word,
            'tekanan_darah' => $this->faker->word,
            'tinggi_badan' => $this->faker->word,
            'suhu' => $this->faker->word,
            'berat_badan' => $this->faker->word,
            'perujuk_id' => \App\Models\Perujuk::factory(),
            'asisten_id' => $this->faker->word,
            'periksa_awal' => $this->faker->text,
            'g' => $this->faker->randomNumber(),
            'p' => $this->faker->randomNumber(),
            'a' => $this->faker->randomNumber(),
            'hpht' => $this->faker->date(),
            'kecelakaan_kerja' => $this->faker->randomNumber(),
            'keterangan' => $this->faker->word,
            'bukan_peserta' => $this->faker->randomNumber(),
            'sistolik' => $this->faker->randomNumber(),
            'diastolik' => $this->faker->randomNumber(),
            'gds' => $this->faker->word,
            'periksa_id' => \App\Models\Periksa::factory(),
            'dipanggil' => $this->faker->boolean,
            'tenant_id' => \App\Models\Tenant::factory(),
            'poli_id' => \App\Models\Poli::factory(),
        ];
    }
}
