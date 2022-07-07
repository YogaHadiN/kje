<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Tenant;

class AntrianFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'jenis_antrian_id'         => 1,
            'url'                      => null,
            'nomor'                    => $this->faker->numerify('##'),
            'antriable_id'             => null,
            'antriable_type'           => 'App\Models\Antrian',
            'whatsapp_registration_id' => null,
            'nomor_bpjs'               => null,
            'dipanggil'                => 0,
            'no_telp'                  => null,
            'poli_id'                  => null,
            'nama_asuransi'            => null,
            'nama'                     => null,
            'tanggal_lahir'            => null,
            'nomor_asuransi'           => null,
            'pembayaran'               => null,
            'konfirmasi_nomor_antrian' => null,
            'alamat'                   => null,
            'tenant_id'                => Tenant::factory()
        ];
    }
}
