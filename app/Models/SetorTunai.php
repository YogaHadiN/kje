<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 
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
}
