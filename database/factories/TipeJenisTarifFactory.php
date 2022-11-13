<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TipeJenisTarifFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'tipe_jenis_tarif' => $this->faker->word,
        ];
    }
}
