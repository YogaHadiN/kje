<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Tenant;
use App\Models\Sediaan;
use App\Models\AturanMinum;

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
            'sediaan_id'         => Sediaan::factory(),
            'aturan_minum_id' => AturanMinum::factory(),
            'peringatan'      => $this->faker->text,
            'boleh_dipuyer'   => rand(0,1),
            'tenant_id'       => Tenant::factory()
        ];
    }
}
