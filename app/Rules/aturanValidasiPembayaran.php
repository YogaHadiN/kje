<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Periksa;
use App\Models\Rekening;
use Carbon\Carbon;

class aturanValidasiPembayaran implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public $request;
    public $message;
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
        $temp = json_decode($value, true);
        $return = true;
        foreach ($temp as $t) {
            //invoice_id harus ada
            $periksa = Periksa::with('invoice.kirim_berkas')->where('id', $t['periksa_id'])->first();
            if (is_null($periksa->invoice)) {
                $this->message[] = 'Piutang <strong>' . ucwords($t['nama_pasien']) . '</strong> tidak dapat diproses karena belum ada invoice (Tagihan belum dikirim)';
                $return = false;
            } else if ( 
                $periksa->invoice->kirim_berkas->tanggal > 
                Carbon::CreateFromFormat('d-m-Y',$this->request->tanggal_dibayar)->format('Y-m-d')  
            ) {
                $this->message[] = 'Piutang <strong>' . ucwords($t['nama_pasien']) . '</strong> tidak dapat diproses karena tanggal pengiriman tagihan <strong>(' . $periksa->invoice->kirim_berkas->tanggal->format('d-m-Y') . ')</strong> didapatkan setelah tanggal dibayar <strong>(' . $this->request->tanggal_dibayar . ')</strong>';
                $return = false;
            }
        }
        return $return;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        $message = '<ul>';
        foreach ( $this->message as $m) {
            $message .= '<li>' . $m. '</li>';
        }
        $message .= '</ul>';
        return $message;
    }
}
