<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Ht;

class HtFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = Ht::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'nama' => $this->faker->word,
            'alamat' => $this->faker->word,
            'tanggal_lahir' => $this->faker->date(),
            'jenis_kelamin' => $this->faker->word,
            'tenant_id' => \App\Models\Tenant::factory(),
        ];
    }
}
