<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Outbox;

class OutboxFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = Outbox::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'UpdatedInDB' => $this->faker->dateTime(),
            'InsertIntoDB' => $this->faker->dateTime(),
            'SendingDateTime' => $this->faker->dateTime(),
            'SendBefore' => $this->faker->time(),
            'SendAfter' => $this->faker->time(),
            'Text' => $this->faker->text,
            'DestinationNumber' => $this->faker->word,
            'Coding' => $this->faker->randomElement(['Default_No_Compression', 'Unicode_No_Compression', '8bit', 'Default_Compression', 'Unicode_Compression']),
            'UDH' => $this->faker->text,
            'Class' => $this->faker->randomNumber(),
            'TextDecoded' => $this->faker->text,
            'MultiPart' => $this->faker->randomElement(['false', 'true']),
            'RelativeValidity' => $this->faker->randomNumber(),
            'SenderID' => $this->faker->word,
            'SendingTimeOut' => $this->faker->dateTime(),
            'DeliveryReport' => $this->faker->randomElement(['default', 'yes', 'no']),
            'CreatorID' => $this->faker->text,
            'Retries' => $this->faker->randomNumber(),
            'Priority' => $this->faker->randomNumber(),
            'tenant_id' => \App\Models\Tenant::factory(),
        ];
    }
}
