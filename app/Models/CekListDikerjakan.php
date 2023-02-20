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
    public function getDangerAttribute(){
        $jumlah        = $this->jumlah;
        $limit_id      = $this->cekListRuangan->limit_id;
        $jumlah_normal = $this->cekListRuangan->jumlah_normal;

        return 
            ( $limit_id == 1 && $jumlah < $jumlah_normal ) ||
            ( $limit_id == 2 && $jumlah > $jumlah_normal ) ||
            ( $limit_id == 3 && $jumlah != $jumlah_normal );
    }
    
}

