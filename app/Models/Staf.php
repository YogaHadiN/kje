<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\BelongsToTenant; 
use Session;
use App\Models\Classes\Yoga;
class Staf extends Model{
    use BelongsToTenant,HasFactory;

	protected $dates = [
		'tanggal_lahir',
		'tanggal_mulai',
		'tanggal_lulus'
	];

	public static function boot(){
		parent::boot();
		self::deleting(function($staf){
			if ($staf->periksa->count() > 0) {
				Session::flash('pesan', Yoga::gagalFlash('Tidak bisa menghapus staf karena staf sudah pernah memeriksa pasien. Hubungi Super Admin untuk konfirmasi penghapusan'));
				return false;
			}
		});
	}

	// Don't forget to fill this array
	protected $guarded = [];

	public function periksa(){

		return $this->hasMany('App\Models\Periksa');
	}

    public function jurnalUmums(){
         return $this->hasManyThrough('App\Models\JurnalUmum', 'App\Models\Periksa', 'staf_id', 'jurnalable_id');
    }

    public function gaji(){
         return $this->hasMany('App\Models\BayarGaji');
    }
	public static function list($all = false){
		if ($all) {
			return [ '%' => 'Semua' ] + Staf::pluck('nama', 'id')->all();
		}
		return [ null => 'pilih' ] + Staf::pluck('nama', 'id')->all();
		
	}

	public function getStatusPernikahanAttribute(){
		$menikah = $this->menikah;
		if ( $menikah ) {
			return 'Menikah';
		} else {
			return 'Tidak Menikah';
		}

	}
    public function berkas(){
        return $this->morphMany('App\Models\Berkas', 'berkasable');
    }
	public function isDokter() {
	   return trim($this->titel) == 'dr';
	}
    public static function owner(){
        return Staf::where('owner', 1)->first();
    }

    public function setStrExpiryDateAttribute($value)
    {
        $this->attributes['str_expiry_date'] = convertToDatabaseFriendlyDateFormat($value);
    }

    public function setSipExpiryDateAttribute($value)
    {
        $this->attributes['sip_expiry_date'] = convertToDatabaseFriendlyDateFormat($value);
    }

    public function setTanggalLahirAttribute($value)
    {
        $this->attributes['tanggal_lahir'] = convertToDatabaseFriendlyDateFormat($value);
    }
    public function setTanggalLulusAttribute($value)
    {
        $this->attributes['tanggal_lulus'] = convertToDatabaseFriendlyDateFormat($value);
    }
    public function setTanggalMulaiAttribute($value)
    {
        $this->attributes['tanggal_mulai'] = convertToDatabaseFriendlyDateFormat($value);
    }
}
