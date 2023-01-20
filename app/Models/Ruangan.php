<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CekListDikerjakan;

class Ruangan extends Model
{
    use HasFactory;
    public function cekListRuangan(){
        return $this->hasMany(CekListRuangan::class);
    }
    public function getStatusHarianAttribute(){
        return $this->status(1);
    }
    public function getStatusBulananAttribute(){
        return $this->status(3);
    }

    public function getJumlahCekListHarianAttribute(){
        $cek_list_ruangans = $this->cekListRuangan;
        $jumlah = 0;
        foreach ($cek_list_ruangans as $cek) {
            if ( $cek->frekuensi_cek_id == 1 ) {
                $jumlah++;
            }
        }
        return $jumlah;
    }

    public function getJumlahCekListBulananAttribute(){
        $cek_list_ruangans = $this->cekListRuangan;
        $jumlah = 0;
        foreach ($cek_list_ruangans as $cek) {
            if ( $cek->frekuensi_cek_id == 3 ) {
                $jumlah++;
            }
        }
        return $jumlah;
    }
    /**
     * undocumented function
     *
     * @return void
     */
    private function status( $frekuensi_cek_id )
    {
        $cek_list_ruangan_ids = CekListRuangan::where('ruangan_id', $this->id)
                                            ->where('frekuensi_cek_id', $frekuensi_cek_id)
                                            ->pluck('id');
        $cek_list_dikerjakan_hari_inis = CekListDikerjakan::whereIn('cek_list_ruangan_id', $cek_list_ruangan_ids)
                                                            ->where('created_at', 'like', $frekuensi_cek_id == 1 ? date('Y-m-d').'%' :date('Y-m').'%' )
                                                            ->groupBy('cek_list_ruangan_id')
                                                            ->get();

        if( $cek_list_ruangan_ids->count() == $cek_list_dikerjakan_hari_inis->count() ){
            return 'oke';
        } else {
            return 'belom';
        }
    }
    
}
