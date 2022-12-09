<?php

namespace App\Imports;

use App\Models\PesertaBpjsPerusahaa;
use Maatwebsite\Excel\Concerns\ToModel;

class PesertaBpjsPerusahaaImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new PesertaBpjsPerusahaa([
            //
        ]);
    }
}
