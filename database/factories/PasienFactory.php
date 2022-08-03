<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Tenant;

class PasienFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */

    public function definition()
    {
        return [
            "nama"                         => $this->faker->name,
            "nama_peserta"                 => $this->faker->name,
            "nomor_asuransi"               => $this->faker->numerify('################'),
            "asuransi_id"                  => \App\Models\Asuransi::factory(),
            "jenis_peserta_id"             => 1,
            "sex"                          => rand(0,1),
            "alamat"                       => $this->faker->address,
            "tanggal_lahir"                => $this->faker->date('Y-m-d'),
            "no_telp"                      => $this->faker->phoneNumber(),
            "nama_ayah"                    => $this->faker->name,
            "nama_ibu"                     => $this->faker->name,
            "riwayat_kehamilan_sebelumnya" => $this->faker->text,
            "image"                        => $this->faker->word,
            "ktp_image"                    => $this->faker->word,
            "bpjs_image"                   => $this->faker->word,
            "nomor_asuransi_bpjs"          => $this->faker->numerify('################'),
            "nomor_ktp"                    => $this->faker->numerify('################'),
            "jangan_disms"                 => rand(0,1),
            "sudah_kontak_bulan_ini"       => rand(0,1),
            "kepala_keluarga_id"           => $this->faker->word,
            "prolanis_ht"                  => rand(0,1),
            "prolanis_dm"                  => rand(0,1),
            "prolanis_ht_flagging_image"   => $this->faker->word,
            "prolanis_dm_flagging_image"   => $this->faker->word,
            "kartu_asuransi_image"         => $this->faker->word,
            "verifikasi_prolanis_dm_id"    => 0,
            "verifikasi_prolanis_ht_id"    => 0,
            "meninggal"                    => 0,
            "penangguhan_pembayaran_bpjs"  => 0,
            "tenant_id"                    => Tenant::factory(),
            "old_id"                       => $this->faker->numerify('################')

        ];
    }
}
