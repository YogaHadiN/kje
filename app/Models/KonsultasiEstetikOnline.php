<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 
use App\Models\GambarPeriksa;

class KonsultasiEstetikOnline extends Model
{
    use HasFactory, BelongsToTenant;
    protected $guarded = [];
    public function gambarPeriksa(){
        return $this->morphMany(GambarPeriksa::class, 'gambarable');
    }
}
