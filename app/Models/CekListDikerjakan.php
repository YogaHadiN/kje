<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CekListDikerjakan extends Model
{
    use HasFactory;
    public function cekListRuangan(){
        return $this->belongsTo(CekListRuangan::class);
    }
}

