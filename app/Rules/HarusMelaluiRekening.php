<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Asuransi;
use App\Rekening;

class HarusMelaluiRekening implements Rule
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

        $asuransi = Asuransi::find( $this->request->asuransi_id );

        if (
            !$asuransi->pelunasan_tunai &&
            (empty( $this->request->rekening_id ) || !isset( Rekening::find($this->request->rekening_id) ))
        ) {
            return false
        }
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
