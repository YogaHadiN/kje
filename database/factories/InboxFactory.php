<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Inbox;

class InboxFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = Inbox::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'UpdatedInDB' => $this->faker->dateTime(),
            'ReceivingDateTime' => $this->faker->dateTime(),
            'Text' => $this->faker->text,
            'SenderNumber' => $this->faker->word,
            'Coding' => $this->faker->randomElement(['Default_No_Compression', 'Unicode_No_Compression', '8bit', 'Default_Compression', 'Unicode_Compression']),
            'UDH' => $this->faker->text,
            'SMSCNumber' => $this->faker->word,
            'Class' => $this->faker->randomNumber(),
            'TextDecoded' => $this->faker->text,
            'RecipientID' => $this->faker->text,
            'Processed' => $this->faker->randomElement(['false', 'true']),
            'tenant_id' => \App\Models\Tenant::factory(),
        ];
    }
}
