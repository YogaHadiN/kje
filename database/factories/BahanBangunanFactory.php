<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\BahanBangunan;

class BahanBangunanFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = BahanBangunan::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'tanggal_renovasi_selesai' => $this->faker->dateTime(),
            'tanggal_terakhir_dikonfirmasi' => $this->faker->date(),
            'bangunan_permanen' => $this->faker->randomNumber(),
            'faktur_belanja_id' => \App\Models\FakturBelanja::factory(),
            'keterangan' => $this->faker->word,
            'harga_satuan' => $this->faker->randomNumber(),
            'jumlah' => $this->faker->randomNumber(),
            'tenant_id' => \App\Models\Tenant::factory(),
        ];
    }
}
