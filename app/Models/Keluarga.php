<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keluarga extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function pasien(){
        return $this->hasMany('App\Models\Pasien');
    }
}
