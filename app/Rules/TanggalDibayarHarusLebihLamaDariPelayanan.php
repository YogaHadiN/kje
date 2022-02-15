<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Carbon\Carbon;

class TanggalDibayarHarusLebihLamaDariPelayanan implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public $request;
    public $mulai;
    public $akhir;
    public $tanggal_dibayar;
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
        $this->mulai           = Carbon::parse($this->request->mulai);
        $this->akhir           = Carbon::parse($this->request->akhir);
        $this->tanggal_dibayar = Carbon::createFromFormat('d-m-Y', trim($this->request->tanggal_dibayar));
        if (
            $this->mulai > $this->tanggal_dibayar ||
            $this->akhir > $this->tanggal_dibayar
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
        return 'Tanggal dibayar harus setelah tanggal periode <strong>(' . $this->mulai->format('d-m-Y'). ' s/d ' . $this->akhir->format('d-m-Y'). ')</strong> sedangkan dibayarl <strong>' . $this->tanggal_dibayar->format('d-m-Y') . '</strong>' ;
    }
}
