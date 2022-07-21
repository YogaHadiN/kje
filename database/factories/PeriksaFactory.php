<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Periksa;

class PeriksaFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = Periksa::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'tanggal' => $this->faker->date(),
            'asuransi_id' => \App\Models\Asuransi::factory(),
            'pasien_id' => \App\Models\Pasien::factory(),
            'staf_id' => \App\Models\Staf::factory(),
            'anamnesa' => $this->faker->text,
            'pemeriksaan_fisik' => $this->faker->word,
            'pemeriksaan_penunjang' => $this->faker->word,
            'diagnosa_id' => \App\Models\Diagnosa::factory(),
            'keterangan_diagnosa' => $this->faker->word,
            'terapi' => $this->faker->text,
            'piutang' => $this->faker->randomNumber(),
            'tunai' => $this->faker->randomNumber(),
            'poli_id' => \App\Models\Poli::factory(),
            'jam' => $this->faker->time(),
            'jam_resep' => $this->faker->time(),
            'transaksi' => $this->faker->text,
            'berat_badan' => $this->faker->randomNumber(),
            'approve_id' => $this->faker->randomNumber(),
            'satisfaction_index' => $this->faker->randomNumber(),
            'piutang_dibayar' => $this->faker->randomNumber(),
            'tanggal_piutang_dibayar' => $this->faker->date(),
            'asisten_id' => $this->faker->word,
            'periksa_awal' => $this->faker->text,
            'jam_periksa' => $this->faker->time(),
            'jam_terima_obat' => $this->faker->time(),
            'jam_selesai_periksa' => $this->faker->time(),
            'kecelakaan_kerja' => $this->faker->randomNumber(),
            'keterangan' => $this->faker->word,
            'resepluar' => $this->faker->text,
            'pembayaran' => $this->faker->randomNumber(),
            'kembalian' => $this->faker->randomNumber(),
            'nomor_asuransi' => $this->faker->word,
            'antrian_periksa_id' => $this->faker->randomNumber(),
            'sistolik' => $this->faker->randomNumber(),
            'diastolik' => $this->faker->randomNumber(),
            'old_asuransi_id' => $this->faker->word,
            'prolanis_dm' => $this->faker->boolean,
            'prolanis_ht' => $this->faker->boolean,
            'antrian_id' => $this->faker->word,
            'invoice_id' => $this->faker->word,
            'tenant_id' => \App\Models\Tenant::factory(),
            'old_id' => $this->faker->word,
        ];
    }
}
