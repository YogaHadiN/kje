<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CekListHarian extends Model
{
    use HasFactory;
    protected $morphClass = 'App\Models\CekListHarian';

    public function whatsappbot(){
        return $this->morphOne(WhatsappBot::class, 'whatsappbotable');
    }
}
