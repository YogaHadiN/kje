<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Asuransi;
use App\Models\Tenant;
use App\Models\Classes\Yoga;
class AsuransiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "nama"             => $this->faker->name,
            "alamat"           => $this->faker->address,
            "tanggal_berakhir" => $this->faker->date('Y-m-d'),
            "tipe_asuransi"    => $this->faker->text,
            "kali_obat"        => $this->faker->numerify('#'),
            "coa_id"           => null,
            "kata_kunci"       => $this->faker->text,
            "aktif"            => rand(0,1),
            "pelunasan_tunai"  => rand(0,1),
            "new_id"           => "",
            "old_id"           => "",
            "tenant_id"        => Tenant::factory()
        ];
    }
}
