<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\JenisPajak;

class JenisPajak extends Model
{
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
