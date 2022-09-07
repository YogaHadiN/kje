<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Http\Controllers\AntrianPeriksasController;
use App\Models\AntrianPoli;

class cekGdsDiNurseStationRequired implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public $id;
    public function __construct($id)
    {
        $this->id = $id;
        dd( 'oke1' );
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
        $antrian_poli = AntrianPoli::with('pasien')->where('id', $this->id)->first();
        $ap = new AntrianPeriksasController;
        if (
            $antrian_poli->pasien->prolanis_dm < 1
        ) {
           return true; 
        } else if ($ap->cekGDSDiNurseStation($antrian_poli) && !empty($value)) {
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
        return ':attribute harus diisi karena pasien adalah prolanis dm';
    }
}
