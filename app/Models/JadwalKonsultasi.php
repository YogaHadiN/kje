<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalKonsultasi extends Model
{
    use HasFactory;
    public function hari(){
        return $this->belongsTo(Hari::class);
    }
    public function staf(){
        return $this->belongsTo(Staf::class);
    }
    public function tipeKonsultasi(){
        return $this->belongsTo(TipeKonsultasi::class);
    }
}
