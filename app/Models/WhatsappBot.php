<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhatsappBot extends Model
{
    use HasFactory;
    public function whatsappBotService(){
        return $this->belongsTo(WhatsappBotService::class);
    }
}
