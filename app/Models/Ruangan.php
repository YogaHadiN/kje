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
    public function getStatusAttribute(){
        $cek_list_dikerjakan = CekListDikerjakan::where('created_at', 'like', date('Y-m-d') . '%')
            ->where('cek_list_ruangan_id', $this->id)
            ->first();
        if ( !is_null( $cek_list_dikerjakan ) ) {
            return 'oke';
        } else {
            return 'bloooom';
        }
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
}
