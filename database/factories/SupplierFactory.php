<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Supplier;

class SupplierFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = Supplier::class;

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
            'no_telp' => $this->faker->word,
            'pic' => $this->faker->word,
            'hp_pic' => $this->faker->word,
            'image' => $this->faker->word,
            'muka_image' => $this->faker->word,
        ];
    }
}
