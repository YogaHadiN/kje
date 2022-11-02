<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\BelongsToTenant; 
use App\Models\Asuransi;

class Antrian extends Model
{
    use BelongsToTenant,HasFactory;

	protected $dates = [
		'tanggal_lahir'
	];
	public function jenis_antrian(){
		return $this->belongsTo('App\Models\JenisAntrian');
	}

	public function whatsapp_registration(){
		return $this->hasOne('App\Models\WhatsappRegistration');
	}

    public function registrasi_pembayaran(){
        return $this->belongsTo(RegistrasiPembayaran::class);
    }

	public function antriable(){
		return $this->morphTo();
	}

	public function getNomorAntrianAttribute(){
		return $this->jenis_antrian->prefix . $this->nomor;
	}
	public function getJenisAntrianIdAttribute($value){
		if ( is_null($value) ) {
			return '6';
		}
		return $value;
	}

	public function getIsTodayAttribute(){
		return $this->created_at->format('Y-m-d') == date('Y-m-d');
	}
    public function getAsuransiIdByRegistrasiPembayaranIdAttribute(){
        $registrasi_pembayaran_id = $this->registrasi_pembayaran_id;
        if ( $registrasi_pembayaran_id == 1 ) {
            return Asuransi::BiayaPribadi()->id;
        } else if( $registrasi_pembayaran_id == 2 ) {
            return Asuransi::BPJS()->id;
        } else{
            return null;
        }
    }
    
}
