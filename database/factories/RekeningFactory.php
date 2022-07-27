<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Rekening;

class RekeningFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = Rekening::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'akun_bank_id'           => \App\Models\AkunBank::factory(),
            'tanggal'                => $this->faker->dateTime(),
            'deskripsi'              => $this->faker->text,
            'nilai'                  => $this->faker->randomFloat(),
            'saldo_akhir'            => $this->faker->randomFloat(),
            'debet'                  => $this->faker->boolean,
            'pembayaran_asuransi_id' => \App\Models\PembayaranAsuransi::factory(),
            'kode_transaksi'         => $this->faker->word,
            'tenant_id'              => \App\Models\Tenant::factory(),
        ];
    }
}
