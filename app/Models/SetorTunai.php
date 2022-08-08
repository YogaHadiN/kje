<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 
use Carbon\Carbon;
class SetorTunai extends Model
{
    use BelongsToTenant, HasFactory;

    public function coa(){
        return $this->belongsTo('App\Models\Coa');
    }

    public function staf(){
        return $this->belongsTo('App\Models\Staf');
    }

    public function jurnals(){
        return $this->morphMany(JurnalUmum::class, 'jurnalable');
    }

    public function getKetjurnalAttribute(){
        $tanggal = Carbon::parse($this->tanggal)->format('d M Y');
        $nama_staf = $this->staf->nama;
        $nama_bank = $this->coa->coa;
        return 'Setor Tunai pada tanggal ' . $tanggal . ' dilakukan Oleh ' . $nama_staf . ' dengan Tujuan : ' . $nama_bank;

    }
}
