<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 

class WhatsappRegistration extends Model
{
    use BelongsToTenant, HasFactory;
	public function getNamaPembayaranAttribute(){
		if ( $this->pembayaran == 'a' ) {
			return 'Biaya Pribadi';
		} else if (  $this->pembayaran == 'b'  ){
			return 'BPJS';
		} else if (  $this->pembayaran == 'c'  ){
			return $this->nama_asuransi ;
		}
	}
	public function antrian(){
		return $this->belongsTo('App\Models\Antrian');
	}
}
