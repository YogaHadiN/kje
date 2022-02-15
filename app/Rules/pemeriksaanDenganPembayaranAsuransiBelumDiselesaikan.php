<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class pemeriksaanDenganPembayaranAsuransiBelumDiselesaikan implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public $request;
    public $periksa_ids;
    public function __construct($request)
    {
        $this->periksa_ids = [];
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

        $piutang_tercatat = json_decode($value, true);
        foreach ($piutang_tercatat as $piu) {
            if (
                $piu['piutang'] == null
            ) {
                $this->periksa_ids[] = [
                    'periksa_id' => $piu['periksa_id'],
                    'nama_pasien' => $piu['nama_pasien']
                ];
            }
        }
        if (count( $this->periksa_ids ) < 1) {
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
        $text = 'Pemeriksaan ';
        $text .= '<ul style="padding-left:20px">';
        foreach ($this->periksa_ids as $pid) {
            $text .= '<li>';
            $text .= '<strong>';
            $text .= $pid['periksa_id'];
            $text .= ' - ';
            $text .= $pid['nama_pasien'];
            $text .= '</strong>';
            $text .= '</li>';
        }
        $text .= '</ul">';
        $text .= 'Belum diselesaikan, mohon selesaikan terlebih dahulu';
        return $text;
    }
}
