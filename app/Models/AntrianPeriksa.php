<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 
use App\Http\Controllers\AntrianPolisController;

class AntrianPeriksa extends Model{
    use BelongsToTenant, HasFactory;
	// Add your validation rules here
	public static $rules = [
		'asuransi_id' => 'required',
		'pasien_id' => 'required',
		'staf_id' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = [];

    public function whatsappBot(){
        return $this->belongsTo(WhatsappBot::class);
    }
	public function asuransi() {
		return $this->belongsTo('App\Models\Asuransi');
	}
	public function poli() {
		return $this->belongsTo('App\Models\Poli');
	}
	public function antrian(){
        return $this->morphOne(Antrian::class, 'antriable');
	}
	public function pasien() {
		return $this->belongsTo('App\Models\Pasien');
	}
    protected $morphClass = 'App\Models\AntrianPeriksa';
    public function antars(){
        return $this->morphMany('App\Models\PengantarPasien', 'antarable');
    }
	public function staf() {
		return $this->belongsTo(Staf::class);
	}

	public function periksa() {
		return $this->belongsTo('App\Models\Periksa');
	}

	public function perujuk(){
		return $this->belongsTo('App\Models\Perujuk');
	}
	public function periksaEx(){
		return $this->hasOne('App\Models\Periksa', 'antrian_periksa_id', 'id');
	}
    public function gambars(){
        return $this->morphMany('App\Models\GambarPeriksa', 'gambarable');
    }
	public static function boot(){
		parent::boot();
		self::deleting(function($antrianperiksa){
			$antrianperiksa->antrian()->delete();
			$apc                     = new AntrianPolisController;
			$apc->updateJumlahAntrian(false, null);
		});
	}
	

}
