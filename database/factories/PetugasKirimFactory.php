<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\PetugasKirim;

class PetugasKirimFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = PetugasKirim::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'staf_id' => \App\Models\Staf::factory(),
            'role_pengiriman_id' => \App\Models\RolePengiriman::factory(),
            'kirim_berkas_id' => $this->faker->word,
            'tenant_id' => \App\Models\Tenant::factory(),
        ];
    }
}
