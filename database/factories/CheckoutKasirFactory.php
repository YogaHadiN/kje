<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\CheckoutKasir;

class CheckoutKasirFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = CheckoutKasir::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'modal_awal' => $this->faker->randomNumber(),
            'uang_keluar' => $this->faker->randomNumber(),
            'uang_masuk' => $this->faker->randomNumber(),
            'debit' => $this->faker->randomNumber(),
            'jurnal_umum_id' => $this->faker->randomNumber(),
            'uang_di_kasir' => $this->faker->randomNumber(),
            'uang_di_tangan' => $this->faker->randomNumber(),
            'detil_pengeluarans' => $this->faker->text,
            'detil_modals' => $this->faker->text,
            'detil_pengeluaran_tangan' => $this->faker->text,
            'tenant_id' => \App\Models\Tenant::factory(),
        ];
    }
}
