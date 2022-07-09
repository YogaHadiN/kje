<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\RegisterAnc;

class RegisterAncFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = RegisterAnc::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'periksa_id' => \App\Models\Periksa::factory(),
            'register_hamil_id' => \App\Models\RegisterHamil::factory(),
            'td' => $this->faker->word,
            'tfu' => $this->faker->word,
            'lila' => $this->faker->word,
            'bb' => $this->faker->word,
            'refleks_patela_id' => \App\Models\RefleksPatela::factory(),
            'djj' => $this->faker->randomNumber(),
            'kepala_terhadap_pap_id' => \App\Models\KepalaTerhadapPap::factory(),
            'jumlah_janin' => $this->faker->randomNumber(),
            'presentasi_id' => \App\Models\Presentasi::factory(),
            'hpht' => $this->faker->date(),
            'catat_di_kia' => \App\Models\Confirm::factory(),
            'inj_tt' => $this->faker->randomNumber(),
            'fe_tablet' => $this->faker->randomNumber(),
            'periksa_hb' => $this->faker->randomNumber(),
            'protein_urin' => $this->faker->randomNumber(),
            'gula_darah' => $this->faker->randomNumber(),
            'thalasemia' => $this->faker->randomNumber(),
            'sifilis' => $this->faker->randomNumber(),
            'hbsag' => $this->faker->randomNumber(),
            'pmtct_konseling' => $this->faker->randomNumber(),
            'pmtct_periksa_darah' => $this->faker->randomNumber(),
            'pmtct_serologi' => $this->faker->randomNumber(),
            'pmtct_arv' => $this->faker->randomNumber(),
            'malaria_periksa_darah' => $this->faker->randomNumber(),
            'malaria_positif' => $this->faker->randomNumber(),
            'malaria_dikasih_obat' => $this->faker->randomNumber(),
            'malaria_dikasih_kelambu' => $this->faker->randomNumber(),
            'tbc_periksa_dahak' => $this->faker->randomNumber(),
            'tbc_positif' => $this->faker->randomNumber(),
            'tbc_dikasih_obat' => $this->faker->randomNumber(),
            'komplikasi_hdk' => $this->faker->randomNumber(),
            'komplikasi_abortus' => $this->faker->randomNumber(),
            'komplikasi_perdarahan' => $this->faker->randomNumber(),
            'komplikasi_infeksi' => $this->faker->randomNumber(),
            'komplikasi_kpd' => $this->faker->randomNumber(),
            'komplikasi_lain_lain' => $this->faker->word,
            'rujukan_puskesmas' => $this->faker->randomNumber(),
            'rujukan_RB' => $this->faker->randomNumber(),
            'rujukan_RSIA_RSB' => $this->faker->randomNumber(),
            'rujukan_RS' => $this->faker->randomNumber(),
            'rujukan_lain' => $this->faker->word,
            'rujukan_tiba_masih_hidup' => $this->faker->word,
            'rujukan_tiba_meninggal' => $this->faker->word,
            'tenant_id' => \App\Models\Tenant::factory(),
        ];
    }
}
