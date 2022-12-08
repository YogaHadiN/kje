<?php

namespace App\Imports;

use App\Models\PesertaBpjsPerusahaan;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
class PesertaBpjsPerusahaanImport implements ToCollection, WithHeadingRow
{

    public function collection(Collection $rows)
    {
        return $rows;
    }
}

