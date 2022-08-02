<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Pasien;
use App\Models\Asuransi;

class CekNomorBpjsSama implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public $dataNomorBpjs;
    public $pasien_dengan_nomor_bpjs_sama;
    public $ambil_dari_nomor_asuransi ;
    public function __construct($dataNomorBpjs)
    {
        $this->dataNomorBpjs = $dataNomorBpjs;
        $this->ambil_dari_nomor_asuransi = false;
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
        $asuransi_bpjs = Asuransi::Bpjs();
        if ( 
            $this->dataNomorBpjs['asuransi_id'] ==  $asuransi_bpjs->id
            && $this->dataNomorBpjs['nomor_asuransi'] != ''
            && $this->dataNomorBpjs['nomor_asuransi_bpjs'] == ''
        ) {
            $this->ambil_dari_nomor_asuransi = true;
            $nomor_asuransi_bpjs = $this->dataNomorBpjs['nomor_asuransi'];
        } else if(
            $this->dataNomorBpjs['nomor_asuransi_bpjs'] != ''
        ) {
            $nomor_asuransi_bpjs = $this->dataNomorBpjs['nomor_asuransi_bpjs'];
        }

        $this->pasien_dengan_nomor_bpjs_sama = Pasien::where('nomor_asuransi_bpjs', $nomor_asuransi_bpjs)
                                                     ->where('id', 'not like', $this->dataNomorBpjs['pasien_id'])
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
        $nomor_asuransi_bpjs = !$this->ambil_dari_nomor_asuransi ? $this->dataNomorBpjs['nomor_asuransi'] : $this->dataNomorBpjs['nomor_asuransi_bpjs'];
        return 'Nomor BPJS <strong>' . $nomor_asuransi_bpjs . '</strong> sudah dipunyai oleh <a href="' . url('/pasiens/' . $this->pasien_dengan_nomor_bpjs_sama->id . '/edit'). '">' . $this->pasien_dengan_nomor_bpjs_sama->nama . '</a> Dilarang membuat pasien ganda. ';
    }
}
