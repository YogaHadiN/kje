<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 

class FollowupTunggakan extends Model
{
    use HasFactory, BelongsToTenant;
    public function staf(){
        return $this->belongsTo(Staf::class);
    }
    public function asuransi(){
        return $this->belongsTo(Asuransi::class);
    }
}
