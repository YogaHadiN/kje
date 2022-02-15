<?php

namespace App\Models;
use App\Models\Coa;

use Illuminate\Database\Eloquent\Model;

class PembayaranAsuransi extends Model
{
    public function asuransi(){
         return $this->belongsTo('App\Models\Asuransi');
    }
    public function staf(){
         return $this->belongsTo('App\Models\Staf');
    }
	public function coa(){
         return $this->belongsTo('App\Models\Coa', 'kas_coa_id');
    }
	public function rekening(){
         return $this->hasOne('App\Models\Rekening');
    }
    protected $dates = ['tanggal_dibayar', 'mulai', 'akhir', 'created_at'];
	protected $morphClass = 'App\Models\PembayaranAsuransi';

    public function jurnals(){
        return $this->morphMany('App\Models\JurnalUmum', 'jurnalable');
    }
    public function getKetjurnalAttribute(){
        $asuransi = Asuransi::find($this->asuransi_id)->nama;
        $pembayaran = $this->pembayaran;
        $tanggal = $this->tanggal_dibayar->format('d-m-Y');
        $kas = Coa::find($this->kas_coa_id)->coa;

        $pesan = 'Telah dibayarkan oleh <strong>' . $asuransi . '</strong><br /> sebesar <strong class="uang">' . $pembayaran . '</strong> pada tanggal <strong>' . $tanggal . '</strong><br /> ke <strong> ' . $kas . '</strong>';
        return $pesan;
    }
    public function piutang_dibayar(){
        return $this->hasMany('App\Models\PiutangDibayar');
    }
}
