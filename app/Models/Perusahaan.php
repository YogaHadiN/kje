<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perusahaan extends Model
{
    use HasFactory;

    public function peserta(){
        return $this->hasMany(PesertaBpjsPerusahaan::class);
    }
}
