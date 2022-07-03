<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Tenant;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $username        = $this->faker->name;
        $role            = 6;
        $password        = '$2y$10$RBSfy5.NMV0ytcU7s4xxBOGMCl9/oC64SET4afYb8wWgucv6uGa8C';
        $email           = $this->faker->email;
        $aktif           = 1;
        $created_at      = date('Y-m-d H:i:s');
        $updated_at      = date('Y-m-d H:i:s');
        $surveyable_type = null;
        $surveyable_id   = null;
        $tenant_id       = Tenant::factory();

        return [
            'username'        => $username,
            'role'            => $role,
            'password'        => $password,
            'email'           => $email,
            'aktif'           => $aktif,
            'created_at'      => $created_at,
            'updated_at'      => $updated_at,
            'surveyable_type' => $surveyable_type,
            'surveyable_id'   => $surveyable_id,
            'tenant_id'       => $tenant_id,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
