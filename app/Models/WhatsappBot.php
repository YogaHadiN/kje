<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Log;

class WhatsappBot extends Model
{

    use HasFactory;
    public static function boot(){
        parent::boot();
        self::creating(function($model){
            Log::info(16);
            resetWhatsappRegistration( $model->no_telp );
        });
    }
    public function whatsappBotService(){
        return $this->belongsTo(WhatsappBotService::class);
    }
}
