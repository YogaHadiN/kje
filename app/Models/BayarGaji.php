<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Staf;

use App\Traits\BelongsToTenant; 
use Illuminate\Database\Eloquent\Model;

class BayarGaji extends Model
{
    use BelongsToTenant, HasFactory;

	protected $guarded = ['id'];
    public function staf(){
         return $this->belongsTo('App\Models\Staf');
    }

    public function sumberUang(){
         return $this->belongsTo('App\Models\Coa', 'sumber_uang_id');
    }
    protected $morphClass = 'App\Models\BayarGaji';
    protected $dates = ['tanggal_dibayar', 'mulai', 'akhir'];

    public function jurnals(){
        return $this->morphMany('App\Models\JurnalUmum', 'jurnalable');
    }
    public function getKetjurnalAttribute(){
        $staf = $this->staf->nama;
        $pembayaran = $this->gaji_pokok + $this->bonus;
        $tanggal = $this->tanggal_dibayar->format('d-m-Y');

        $pesan = 'Telah dibayarkan kepada <strong>' . $staf . '</strong><br /> sebesar <strong class="uang">' . $pembayaran . '</strong> pada tanggal <strong>' . $tanggal . '</strong>';
        return $pesan;
    }
    
    public function pph21s(){
        return $this->morphOne('App\Models\Pph21', 'pph21able');
    }
}
