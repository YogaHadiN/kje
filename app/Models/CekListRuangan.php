<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CekListRuangan extends Model
{
    use HasFactory;
    public function cek_list(){
        return $this->belongsTo(CekList::class);
    }
    public function limit(){
        return $this->belongsTo(Limit::class);
    }
    public function frekuensi_cek(){
        return $this->belongsTo(FrekuensiCek::class);
    }
    public function ruangan(){
        return $this->belongsTo(Ruangan::class);
    }
}
