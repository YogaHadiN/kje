<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 
use App\Models\JenisPajak;

class JenisPajak extends Model
{
    use BelongsToTenant, HasFactory;
    /**
     * undocumented function
     *
     * @return void
     */
    public static function list()
    {
		return  JenisPajak::pluck('jenis_pajak', 'id');
    }
    public function periode(){
        return $this->belongsTo('App\Models\Periode');
    }
    
}
