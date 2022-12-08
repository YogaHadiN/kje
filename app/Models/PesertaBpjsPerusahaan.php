<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesertaBpjsPerusahaan extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function perusahaan(){
        return $this->belongsTo(Perusahaan::class);
    }
}
