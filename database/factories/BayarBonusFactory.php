<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\BayarBonus;

class BayarBonusFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = BayarBonus::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'staf_id'         => \App\Models\Staf::factory(),
            'mulai'           => $this->faker->date('Y-m-d'),
            'akhir'           => $this->faker->date('Y-m-d'),
            'pembayaran'      => $this->faker->numerify('###'),
            'tanggal_dibayar' => $this->faker->date('Y-m-d'),
            'kas_coa_id'      => \App\Models\Coa::factory(),
            'tenant_id'       => \App\Models\Tenant::factory()
        ];
    }
}
