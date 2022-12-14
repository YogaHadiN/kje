<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Auth;

class ExpDateHarusFormatTahunBulan implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        $terapi = json_decode($value, true);
        $valid_format = true;
        if ( Auth::user()->tenant->exp_date_validation_available ) {
            foreach ($terapi as $t) {
                if (
                    isset($t['exp_date']) &&
                    !empty($t['exp_date']) 
                ) {
                    try {
                        Carbon::createFromFormat('Y-m', $t['exp_date']);
                    } catch (\Exception $e) {
                        $valid_format = false;
                    }
                }
            }
        }
        return $valid_format;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Expiry Date harus dalam format YYYYY-MM (Tahun dulu baru bulan)';
    }
}
