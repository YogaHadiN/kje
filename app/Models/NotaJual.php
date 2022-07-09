<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 

class NotaJual extends Model{
    use BelongsToTenant, HasFactory;
	
	protected $fillable = [];
	protected $dates = [ 'tanggal' , 'created_at'];

    protected $morphClass = 'App\Models\NotaJual';

    public function penjualan(){
         return $this->hasMany('App\Models\Penjualan');
    }
    public function pendapatan(){
         return $this->hasMany('App\Models\Pendapatan');
    }
    public function staf(){
         return $this->belongsTo('App\Models\Staf');
    }
    public function tipeJual(){
         return $this->belongsTo('App\Models\TipeJual');
    }
    public function pembayaranAsuransi(){
         return $this->hasMany('App\Models\PembayaranAsuransi');
    }
    public function dispenses(){
        return $this->morphMany('App\Models\Dispensing', 'dispensable');
    }
    public function jurnals(){
        return $this->morphMany('App\Models\JurnalUmum', 'jurnalable');
    }
	public function getNilaiAttribute(){
		return JurnalUmum::where('jurnalable_type', 'App\Models\NotaJual')
						->where('jurnalable_id', $this->id)
						->where('debit', '1')
						->first()['nilai'];
	}

	public function getItemsAttribute(){
		return $this->penjualan->count() . ' pcs';
	}
	
	
    public function getTotalAttribute(){
        $total = 0;
        if ($this->tipe_jual_id == 1) {
            $penjualans = $this->penjualan;
            foreach ($penjualans as $penj) {
                $total += $penj->harga_jual * $penj->jumlah;
            }
        }else if($this->tipe_jual_id == 2){
            $pendapatans = $this->pendapatan;
            foreach ($pendapatans as $penj) {
                $total += $penj->biaya;
            }
        }
        return $total;
    }
    public function getKetjurnalAttribute(){

        $pembayaran_asuransis = $this->pembayaranAsuransi;

        if ($pembayaran_asuransis->count() > 0){
            $biaya = 0;
            foreach ($pembayaran_asuransis as $pemb) {
                $biaya += $pemb->pembayaran;
            }
             $temp = 'Pembayaran Piutang<strong> Asuransi ' . $pembayaran_asuransis->first()->asuransi->nama . '</strong>';
             $temp .= '<br />pada tanggal <strong>' . $this->tanggal->format('d-m-Y') . '</strong>';
             $temp .= '<br />sebesar<strong> <span class="uang">' . $biaya . '</span></strong>';
             $temp .= '<br />Tujuan kas di <strong> <span>' . $pemb->coa->coa . '</span></strong>';
             return $temp;
        }else {
            $penjualans = $this->penjualan;
            $juals = '<ul>';
            $nilai = 0;
            foreach ($penjualans as $penj) {
                $merek = $penj->merek->merek;
                $juals .= '<li>' . $merek . '(' . $penj->jumlah . ' pcs), </li> ';
                $nilai += $penj->jumlah * $penj->harga_jual;
            }
            $juals .= '</ul>';
            return 'Penjualan <strong>' .  $juals .  ' </strong>sebesar <strong><span class="uang">' . $nilai . '</span></strong>';
        }
    }
}
