<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Classes\Yoga;
use App\Rekening;

class pembayaranAsuransiHarusSama implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public $request;
    public function __construct($request)
    {
        $this->request = $request;
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
        $rekening = Rekening::find( $this->request->rekening_id );
        $dibayar  = (int) Yoga::clean($value);
        if ( !is_null( $rekening ) ) {
            $nilai = (int) $rekening->nilai;
            return $dibayar === $nilai;
        } else {
            return true;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Yang dibayar harus sama dengan jumlah di rekening';
    }
}
