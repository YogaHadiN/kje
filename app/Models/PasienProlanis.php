<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\BelongsToTenant; 
use Illuminate\Database\Eloquent\Model;

class PasienProlanis extends Model
{
    use BelongsToTenant;
    protected $guarded = [];
    public function pasien(){
        return $this->belongsTo(Pasien::class);
    }
}
