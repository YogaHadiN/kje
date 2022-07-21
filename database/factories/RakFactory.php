<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Tenant;

class RakFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'harga_beli'        => $this->faker->numerify('##'),
            'formula_id'        => \App\Models\Formula::factory(),
            'kode_rak'        => $this->faker->numerify('##'),
            'harga_jual'        => $this->faker->numerify('##'),
            'exp_date'          => $this->faker->date('Y-m-d'),
            'fornas'            => rand(0,1),
            'stok_minimal'      => $this->faker->numerify('##'),
            'stok'              => $this->faker->numerify('##'),
            'alternatif_fornas' => null,
            'kelas_obat_id'     => rand(1,3),
            'tenant_id'         => Tenant::factory(),
        ];
    }
}
