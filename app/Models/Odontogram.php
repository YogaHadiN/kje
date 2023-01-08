<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 

class Odontogram extends Model
{
    
    use BelongsToTenant,HasFactory;

    public static function boot(){
        parent::boot();
        self::created(function($model){
            if (empty($model->taksonomiGigi->taksonomi_gigi_anak)) {
                $model->matur = 1;
                $model->save();
            }
        });
    }
    protected $guarded = [];


    public static function dewasa($taksonomi_gigi_id, $pasien_id){
        return !Odontogram::where('pasien_id', $pasien_id)
            ->where('taksonomi_gigi_id', $taksonomi_gigi_id)
            ->whereNotNull('matur')
            ->exists();
    }

    public function keadaanGigi(){
        return $this->hasMany('App\Models\KeadaanGigi');
    }
    public function taksonomiGigi(){
        return $this->belongsTo(TaksonomiGigi::class);
    }

    public function tindakanGigi(){
        return $this->hasMany(TindakanGigi::class);
    }
    
}
