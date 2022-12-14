<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class BBHarusDiisiKalauAdaPuyer implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */

    public $terapi
    public function __construct($terapi)
    {
        $this->terapi = $terapi;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        dd( $terapi );
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The validation error message.';
    }
}
