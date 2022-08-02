<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\NotaBeli;

class NotaBeliFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = NotaBeli::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'nomor_faktur' => $this->faker->word,
            'tanggal' => $this->faker->date(),
            'staf_id' => \App\Models\Staf::factory(),
            'supplier_id' => \App\Models\Supplier::factory(),
            'jumlah' => $this->faker->randomNumber(),
            'tenant_id' => \App\Models\Tenant::factory(),
            'old_id' => $this->faker->word,
        ];
    }
}
