<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 
use Session;
use App\Models\Classes\Yoga;

class Staf extends Model{
    use BelongsToTenant;

	protected $dates = [
		'tanggal_lahir',
		'tanggal_mulai',
		'tanggal_lulus'
	];
	public $incrementing = false; 
    protected $keyType = 'string';

	public static function boot(){
		parent::boot();
		self::deleting(function($staf){
			if ($staf->periksa->count() > 0) {
				Session::flash('pesan', Yoga::gagalFlash('Tidak bisa menghapus staf karena staf sudah pernah memeriksa pasien. Hubungi Super Admin untuk konfirmasi penghapusan'));
				return false;
			}
		});
	}
	public static $rules = [
		'nama'            => 'required|unique:stafs,nama',
		'alamat_domisili' => 'required',
		'jenis_kelamin'   => 'required',
		'ktp'             => 'required',
		'menikah'         => 'required',
		'jumlah_anak'     => 'required',
		'no_telp'         => 'required'
	];

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
}
