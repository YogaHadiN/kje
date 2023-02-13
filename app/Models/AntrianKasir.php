<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 
use Input;
use Log;

class AntrianKasir extends Model
{
    use BelongsToTenant, HasFactory;
    public static function boot(){
        parent::boot();
        self::created(function($model){
            if (is_null( $model->antrian )) {
                Log::info('=================================');
                Log::info("waktu");
                Log::info( date('Y-m-d H:i:s') );
                Log::info(Input::url());
                Log::info(Input::all());
                Log::info('=================================');
            }
        });
    }
    
    public function periksa(){
        return $this->belongsTo('App\Models\Periksa');
    }
	public function antrian(){
        return $this->morphOne('App\Models\Antrian', 'antriable');
	}
    public function antars(){
        return $this->morphMany('App\Models\PengantarPasien', 'antarable');
    }
}
