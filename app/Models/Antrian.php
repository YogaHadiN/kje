<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\BelongsToTenant; 
use App\Models\Asuransi;
use DB;

class Antrian extends Model
{
    use BelongsToTenant,HasFactory;

    protected $guarded = [];
	protected $dates = [
		'tanggal_lahir'
	];
	public function jenis_antrian(){
		return $this->belongsTo('App\Models\JenisAntrian');
	}

	public function whatsapp_registration(){
		return $this->hasOne(WhatsappRegistration::class);
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
    public function pasien(){
        return $this->belongsTo(Pasien::class);
    }
    public function getRegistrasiSebelumnyaAttribute(){
        $no_telp = $this->no_telp;
        $query  = "SELECT ";
        $query .= "psn.nama as nama_pasien, ";
        $query .= "psn.id as id_pasien ";
        $query .= "FROM antrians as ant ";
        $query .= "JOIN periksas as prx on prx.id = ant.antriable_id and antriable_type = 'App\\\Models\\\Periksa' ";
        $query .= "JOIN pasiens as psn on psn.id = prx.pasien_id ";
        $query .= "WHERE ant.no_telp = '{$no_telp}' ";
        return DB::select($query);

    }
    
    
}
