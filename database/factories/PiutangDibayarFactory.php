<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\PiutangDibayar;

class PiutangDibayarFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = PiutangDibayar::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'periksa_id' => \App\Models\Periksa::factory(),
            'pembayaran' => $this->faker->randomNumber(),
            'pembayaran_asuransi_id' => \App\Models\PembayaranAsuransi::factory(),
            'tenant_id' => \App\Models\Tenant::factory(),
        ];
    }
}
