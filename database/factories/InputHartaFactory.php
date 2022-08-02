<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\InputHarta;

class InputHartaFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = InputHarta::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'harta' => $this->faker->word,
            'coa_id' => $this->faker->word,
            'tanggal_beli' => $this->faker->dateTime(),
            'tanggal_dijual' => $this->faker->date(),
            'coa_penyusutan_id' => $this->faker->word,
            'hutang_terbayar' => $this->faker->randomNumber(),
            'coa_hutang_id' => $this->faker->word,
            'harga' => $this->faker->word,
            'metode_bayar_id' => $this->faker->randomNumber(),
            'uang_muka' => $this->faker->randomNumber(),
            'harga_jual' => $this->faker->randomNumber(),
            'status_harta_id' => \App\Models\StatusHarta::factory(),
            'lama_cicilan' => $this->faker->randomNumber(),
            'masa_pakai' => $this->faker->randomNumber(),
            'staf_id' => $this->faker->word,
            'tax_amnesty' => $this->faker->randomNumber(),
            'tenant_id' => \App\Models\Tenant::factory(),
        ];
    }
}
