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
            'jenis_antrian_id'         => \App\Models\JenisAntrian::factory(),
            'url'                      => null,
            'nomor'                    => $this->faker->numerify('##'),
            'antriable_id'             => null,
            'antriable_type'           => 'App\Models\Antrian',
            'whatsapp_registration_id' => null,
            'nomor_bpjs'               => null,
            'dipanggil'                => 0,
            'kode_unik'                => $this->faker->numerify('#####'),
            'tenant_id'                => Tenant::factory()
        ];
    }
}
