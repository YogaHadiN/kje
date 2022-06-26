<?php

namespace App\Models;
use App\Models\Staf;

use App\Traits\BelongsToTenant; 
use Illuminate\Database\Eloquent\Model;

class BayarGaji extends Model
{
    use BelongsToTenant;

	protected $guarded = ['id'];
    public function staf(){
         return $this->belongsTo('App\Models\Staf');
    }
    public function coa(){
         return $this->belongsTo('App\Models\Coa', 'kas_coa_id');
    }
    protected $morphClass = 'App\Models\BayarGaji';
    protected $dates = ['tanggal_dibayar', 'mulai', 'akhir'];

    public function jurnals(){
        return $this->morphMany('App\Models\JurnalUmum', 'jurnalable');
    }
    public function getKetjurnalAttribute(){
        $staf = Staf::find($this->staf_id)->nama;
        $pembayaran = $this->gaji_pokok + $this->bonus;
        $tanggal = $this->tanggal_dibayar->format('d-m-Y');

        $pesan = 'Telah dibayarkan kepada <strong>' . $staf . '</strong><br /> sebesar <strong class="uang">' . $pembayaran . '</strong> pada tanggal <strong>' . $tanggal . '</strong>';
        return $pesan;
    }
    
    public function pph21s(){
        return $this->morphOne('App\Models\Pph21', 'pph21able');
    }
}
