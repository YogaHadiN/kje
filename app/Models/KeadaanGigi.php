<?php

namespace App\Models;

use App\Traits\BelongsToTenant; 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeadaanGigi extends Model
{
    public static function boot(){
        parent::boot();
        self::created(function($model){
            $model->matur = $model->odontogram->matur;
            $model->save();
        });
    }
    
    protected $guarded = [];
    use BelongsToTenant,HasFactory;
    public function odontogram(){
        return $this->belongsTo(Odontogram::class);
    }
    public function odontogramAbbreviation(){
        return $this->belongsTo(OdontogramAbbreviation::class);
    }
    public function taksonomiGigi(){
        return $this->belongsTo(TaksonomiGigi::class);
    }

    public function permukaanGigi(){
        return $this->belongsTo(PermukaanGigi::class);
    }
}
