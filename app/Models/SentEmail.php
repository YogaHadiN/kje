<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\BelongsToTenant; 
use Illuminate\Database\Eloquent\Model;

class SentEmail extends Model
{
    use HasFactory, BelongsToTenant;
    public function staf(){
        return $this->belongsTo(Staf::class);
    }
}
