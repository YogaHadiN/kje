<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\UploadedFile;

class ExceRule implements Rule
{
    private $file;

    public function __construct($file)
    {
        $this->file = $file;
    }

    public function passes($attribute, $value)
    {
        $mimetype = strtolower($this->file->getClientMimeType());

        return in_array($mimetype, ['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-excel', 'text/csv']);
    }

    public function message()
    {
        return 'The excel file must be a file of type: csv, xls, xlsx.';
    }
}
