<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Pasien;

class CekNomorBpjsSama implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public $request;
    public $pasien_dengan_nomor_bpjs_sama;
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
        $nomor_asuransi_bpjs       = '';
        $ambil_dari_nomor_asuransi = false;
        if ( 
            $this->request->asuransi_id == '32' 
            && $this->request->nomor_asuransi != ''
            && $this->request->nomor_asuransi_bpjs == ''
        ) {
            $ambil_dari_nomor_asuransi = true;
            $nomor_asuransi_bpjs = $this->request->nomor_asuransi;
        } else if(
            $this->request->nomor_asuransi_bpjs != ''
        ) {
            $nomor_asuransi_bpjs = $this->request->nomor_asuransi_bpjs;
        }

        $this->pasien_dengan_nomor_bpjs_sama = Pasien::where('nomor_asuransi_bpjs', $nomor_asuransi_bpjs)
                                                     ->where('id', 'not like', $this->request->pasien_id)
                                                     ->first();

        if (
            is_null($this->pasien_dengan_nomor_bpjs_sama)
            || empty($nomor_asuransi_bpjs)
        ) {
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
        return 'Nomor BPJS pasien sudah dipunyai oleh <a href="' . url('/pasiens/' . $this->pasien_dengan_nomor_bpjs_sama->id . '/edit'). '">' . $this->pasien_dengan_nomor_bpjs_sama->nama . '</a> Dilarang membuat pasien ganda. Salah satunya pasti salah';
    }
}
