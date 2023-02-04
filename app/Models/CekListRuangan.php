<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CekListRuangan extends Model
{
    use HasFactory;
    public function cekList(){
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
    /**
     * undocumented function
     *
     * @return void
     */
    public static function harian()
    {
        return CekListRuangan::with('cekList', 'ruangan')
                            ->where('frekuensi_cek_id', 1)
                            ->orderBy('ruangan_id', 'asc')
                            ->orderBy('cek_list_id', 'asc')
                            ->get();
    }
    
}
