<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Rekening;
use App\Models\Asuransi;

class asuransiIdHarusSesuaiDenganDeskripsi implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public $request;
    public $deskripsi;
    public $rekening_id;
    public function __construct($req)
    {
        $this->request     = $req['request'];
        $this->rekening_id = $req['rekening_id'];
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
        $rekening = Rekening::find( $this->rekening_id );
        $this->deskripsi = $rekening->deskripsi;
        if ( 
            str_contains( $this->deskripsi, '/P') &&	//deskripsi mengandung /P
            ( getAsuransiIdFromDescription($this->deskripsi) !== $value)
        ) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        $asuransi = Asuransi::find( getAsuransiIdFromDescription($this->deskripsi) );
        return 'asuransi yang dipilih salah, karena pembayaran ini milik ' . $asuransi->nama ;
    }
}
