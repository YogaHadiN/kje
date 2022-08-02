<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\KirimBerkas;

class KirimBerkasFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = KirimBerkas::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'tanggal' => $this->faker->dateTime(),
            'foto_berkas_dan_bukti' => $this->faker->word,
            'pengeluaran_id' => \App\Models\Pengeluaran::factory(),
            'alamat' => $this->faker->text,
            'tenant_id' => \App\Models\Tenant::factory(),
            'old_id' => $this->faker->word,
        ];
    }
}
