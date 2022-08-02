<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Rujukan;

class RujukanFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = Rujukan::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'periksa_id' => \App\Models\Periksa::factory(),
            'tujuan_rujuk_id' => \App\Models\TujuanRujuk::factory(),
            'rumah_sakit_id' => \App\Models\RumahSakit::factory(),
            'complication' => $this->faker->word,
            'register_hamil_id' => \App\Models\RegisterHamil::factory(),
            'image' => $this->faker->word,
            'time' => $this->faker->word,
            'age' => $this->faker->word,
            'comorbidity' => $this->faker->word,
            'tacc' => $this->faker->randomNumber(),
            'diagnosa_id' => \App\Models\Diagnosa::factory(),
            'tenant_id' => \App\Models\Tenant::factory(),
        ];
    }
}
