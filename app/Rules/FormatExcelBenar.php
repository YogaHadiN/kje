<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Rules\FormatExcelBenar;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PembayaranImport;

class FormatExcelBenar implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public $request;
    public $baris;
    public $string;
    public function __construct($request)
    {
        $this->request = $request;
        $this->baris = 0;
        $this->string = '';
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
		$excel_pembayaran = [];
        

		if ($this->request->hasFile('excel_pembayaran')) {
			$file =$this->request->file('excel_pembayaran'); //GET FILE
			$excel_pembayaran = Excel::toArray(new PembayaranImport, $file)[0];
            foreach ($excel_pembayaran as $k => $xcl) {
                
                if (
                    (
                        isset($xcl[1]) &&
                        !isset($xcl[0])
                    ) ||
                    (
                        !isset($xcl[1]) &&
                        isset($xcl[0])
                    )
                ) {
                    $this->baris = $k +1;
                    $this->string = $xcl[0] .', '.$xcl[1];
                    return false;
                    return false;
                }
                if (!is_numeric( rpToNumber($xcl[1]) )) {
                    $this->baris = $k +1;
                    $this->string = $xcl[0] .', '.$xcl[1];
                    return false;
                }
            }
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
        return 'kesalahan ada pada ' .$this->baris . ' dengan deskripsi '. $this->string;
    }
}
