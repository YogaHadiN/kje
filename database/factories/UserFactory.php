<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;

class UserFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = User::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'username'        => $this->faker->userName,
            'role_id'         => \App\Models\Role::factory(),
            'password'        => bcrypt($this->faker->password),
            'email'           => $this->faker->safeEmail,
            'remember_token'  => Str::random(10),
            'aktif'           => 1,
            'surveyable_type' => $this->faker->word,
            'surveyable_id'   => $this->faker->word,
            'tenant_id'       => \App\Models\Tenant::factory(),
        ];
    }
}
