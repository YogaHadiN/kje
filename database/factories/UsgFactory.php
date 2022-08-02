<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Usg;

class UsgFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = Usg::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'periksa_id' => $this->faker->word,
            'perujuk_id' => \App\Models\Perujuk::factory(),
            'hpht' => $this->faker->date(),
            'umur_kehamilan' => $this->faker->word,
            'gpa' => $this->faker->word,
            'bpd' => $this->faker->word,
            'ltp' => $this->faker->word,
            'djj' => $this->faker->word,
            'ac' => $this->faker->word,
            'efw' => $this->faker->word,
            'fl' => $this->faker->word,
            'sex' => $this->faker->word,
            'ica' => $this->faker->word,
            'plasenta' => $this->faker->word,
            'presentasi' => $this->faker->word,
            'kesimpulan' => $this->faker->text,
            'saran' => $this->faker->word,
            'bpd_mm' => $this->faker->randomNumber(),
            'fl_mm' => $this->faker->randomNumber(),
            'ac_mm' => $this->faker->randomNumber(),
            'hc' => $this->faker->word,
            'hc_mm' => $this->faker->randomNumber(),
            'tenant_id' => \App\Models\Tenant::factory(),
            'old_id' => $this->faker->word,
        ];
    }
}
