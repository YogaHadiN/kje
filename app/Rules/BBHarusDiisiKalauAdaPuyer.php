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

    public $terapi;
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
        $terapis = json_decode( $this->terapi, true );
        /* dd( $terapis ); */
        $racikan_available = false;
        foreach ($terapis as $terapi) {
            if (
                 strtolower($terapi['signa']) == 'puyer' ||
                 strtolower($terapi['signa']) == 'add' 
            ) {
                $racikan_available = true;
            }
        }
        /* dd($racikan_available ); */
        /* dd($value); */
        /* dd(!empty($value)); */

        dd(
            $racikan_available,
            !empty($value)
        );

        return ( $racikan_available && !empty($value) ) || !$racikan_available ;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Berat Badan harus diisi apabila ada resep racikan';
    }
}
