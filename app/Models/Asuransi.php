<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Classes\Yoga;
use App\Models\Asuransi;
use DB;


class Asuransi extends Model{
    use BelongsToTenant, HasFactory;

	// Add your validation rules here
	public static $rules = [
		'nama' => 'required',
		'email' => 'email'
	];

	public function pic(){
		return $this->hasMany('App\Models\Pic');
	}
    public function emails(){
		return $this->morphMany('App\Models\Email', 'emailable');
		/* if(is_null($this->morphMany('App\Email', 'emailable'))){ */
		/* 	return []; */
		/* } else { */
		/* 	return $this->morphMany('App\Email', 'emailable'); */
		/* } */
    }

	// Don't forget to fill this array
	protected $guarded = [];

	public function periksa(){

		return $this->hasMany('App\Models\Periksa');
	}
	public function tarif(){

		return $this->hasMany('App\Models\Tarif');
	}
	public function getUmumstringAttribute(){

		$umums = $this->umum;
		$string = '';

		try {
			$umums = json_decode($umums, true);
			foreach ($umums as $str) {
				$string .= $str . '&#013;';
			}
	    } catch (\Exception $e) {
	        $string = $umums;
	    }

		return Yoga::emptyIfNull($string);
	}
	public function getGigistringAttribute(){

		$umums = $this->gigi;
		$string = '';

		try {

			$umums = json_decode($umums, true);
			foreach ($umums as $str) {
				$string .= $str . '&#013;';
			}

	    } catch (\Exception $e) {

	        $string = $umums;

	    }

		return Yoga::emptyIfNull($string);
	}
	public function getRujukanstringAttribute(){

		$umums = $this->rujukan;
		$string = '';

		try {
			$umums = json_decode($umums, true);
			foreach ($umums as $str) {
				$string .= $str . '&#013;';
			}
	    } catch (\Exception $e) {
	        $string = $umums;
	    }

		return Yoga::emptyIfNull($string);
	}
	public function getPenagihanstringAttribute(){

		$umums = $this->penagihan;
		$string = '';

		try {
			$umums = json_decode($umums, true);
			foreach ($umums as $str) {
				$string .= $str . '&#013;';
			}
	    } catch (\Exception $e) {
	        $string = $umums;
	    }

		return Yoga::emptyIfNull($string);
	}
	public function getBelumAttribute(){
		$query = "SELECT count(px.id) as jumlah ";
		$query .= "from periksas as px ";
		$query .= "join pasiens as p on px.pasien_id = p.id ";
		$query .= "join asuransis as asu on asu.id = px.asuransi_id ";
		$query .= "where px.piutang > 0 ";
		$query .= "and px.piutang > px.piutang_dibayar ";
		$query .= "and px.tenant_id = " . session()->get('tenant_id') . " ";
		$query .= "and px.asuransi_id = '{$this->id}' ";
		return DB::select($query)[0]->jumlah;
	}
	public static function list(){
		return  Asuransi::pluck('nama', 'id');
		/* return  Asuransi::where('aktif', 1)->pluck('nama', 'id'); */
	}
	public function tipe_asuransi(){
		return $this->belongsTo('App\Models\TipeAsuransi');
	}
	
    public function telpons(){
		return $this->morphMany('App\Models\Telpon', 'telponable');
    }

    public function berkas(){
        return $this->morphMany('App\Models\Berkas', 'berkasable');
    }
    public static function Bpjs(){
        return Asuransi::where('tipe_asuransi_id', 5)->first();
    }

    public static function BiayaPribadi(){
        return Asuransi::where('tipe_asuransi_id', 1)->first();
    }
    public function coa(){
        return $this->belongsTo(Coa::class);
    }
    
}
