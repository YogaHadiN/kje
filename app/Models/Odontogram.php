<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Odontogram extends Model
{
    use HasFactory;

    public static function dewasa($taksonomi_gigi_id, $pasien_id){
        return !Odontogram::where('pasien_id', $pasien_id)
            ->where('taksonomi_gigi_id', $taksonomi_gigi_id)
            ->whereNotNull('menjadi_dewasa')
            ->exists();
    }
    
}
