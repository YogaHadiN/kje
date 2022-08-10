<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SetorTunaiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "tanggal"    => $this->faker->date('d-m-Y'),
            "staf_id"    => \App\Models\Staf::factory(),
            "coa_id"     => \App\Models\Coa::factory(),
            "nominal"    => $this->faker->numerify('Rp.#.###.###'),
            "nota_image" => $this->faker->text,
            "tenant_id"  => \App\Models\Tenant::factory(),
        ];
    }
}
