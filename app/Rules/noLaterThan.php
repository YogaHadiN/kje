<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Carbon\Carbon;

class noLaterThan implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public $request;
    public $akhir_periode_bulan;
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
        $periode_bulan             = '01-' . $this->request->periode_bulan;
        $this->akhir_periode_bulan = Carbon::createFromFormat('d-m-Y',$periode_bulan )->endOfMonth();
        $akhir_periode_bulan       = $this->akhir_periode_bulan->timestamp;
        $value                     = Carbon::createFromFormat('d-m-Y',$value )->timestamp;

        return $value > $akhir_periode_bulan;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Tanggal pembayaran harus setelah akhir periode pelayanan ( ' . $this->akhir_periode_bulan->format('d-m-Y'). ' )';
    }
}
