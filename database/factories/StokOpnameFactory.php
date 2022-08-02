<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\StokOpname;

class StokOpnameFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = StokOpname::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'rak_id' => $this->faker->word,
            'stok_komputer' => $this->faker->randomNumber(),
            'stok_fisik' => $this->faker->randomNumber(),
            'exp_date' => $this->faker->date(),
            'staf_id' => $this->faker->word,
            'tenant_id' => \App\Models\Tenant::factory(),
        ];
    }
}
