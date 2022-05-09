<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Pasien;

class CekNomorKtpSama implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public $request;
    public $pasien;
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
        $this->pasien = Pasien::where('nomor_ktp', $value)->first();
        if ( is_null( $this->pasien ) ) {
            return true;
        }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Nomor KTP sudah dimiliki oleh <a href="' . url('pasiens/'. $this->pasien->id '/edit'). '" >' . $this->pasien->nama. '</a>. Tidak mungkin 2 pasien memiliki Nomor KTP yang sama';
    }
}
