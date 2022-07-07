<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Tenant;

class FormulaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'indikasi'        => $this->faker->text,
            'kontraindikasi'  => $this->faker->text,
            'efek_samping'    => $this->faker->text,
            'dijual_bebas'    => rand(0,1),
            'sediaan'         => rand(1,14),
            'aturan_minum_id' => 1,
            'peringatan'      => $this->faker->text,
            'tidak_dipuyer'   => rand(0,1),
            'tenant_id'       => Tenant::factory()
        ];
    }
}
