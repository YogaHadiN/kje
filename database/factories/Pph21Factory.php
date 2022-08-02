<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Pph21;

class Pph21Factory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = Pph21::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'pph21able_id' => $this->faker->word,
            'pph21able_type' => $this->faker->word,
            'pph21' => $this->faker->randomNumber(),
            'menikah' => $this->faker->randomNumber(),
            'punya_npwp' => $this->faker->randomNumber(),
            'jumlah_anak' => $this->faker->randomNumber(),
            'ptkp_dasar' => $this->faker->randomNumber(),
            'ptkp_setahun' => $this->faker->randomNumber(),
            'penghasilan_kena_pajak_setahun' => $this->faker->randomNumber(),
            'biaya_jabatan' => $this->faker->randomNumber(),
            'gaji_netto' => $this->faker->randomNumber(),
            'gaji_bruto' => $this->faker->randomNumber(),
            'potongan5persen_setahun' => $this->faker->randomNumber(),
            'potongan15persen_setahun' => $this->faker->randomNumber(),
            'potongan25persen_setahun' => $this->faker->randomNumber(),
            'potongan30persen_setahun' => $this->faker->randomNumber(),
            'pph21_setahun' => $this->faker->randomNumber(),
            'ikhtisar_gaji_bruto' => $this->faker->text,
            'tenant_id' => \App\Models\Tenant::factory(),
        ];
    }
}
