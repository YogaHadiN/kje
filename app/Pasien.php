<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Session;
use DB;
use App\Classes\Yoga;

class Pasien extends Model{
	public static function boot(){
		parent::boot();
		self::deleting(function($pasien){
			if ($pasien->periksa->count() > 0) {
				Session::flash('pesan', Yoga::gagalFlash('Tidak bisa menghapus pasien karena sudah ada pemeriksaan sebelumnya'));
				return false;
			}
			if ($pasien->antrianPeriksa->count() > 0 || $pasien->antrianPoli->count() > 0) {
				Session::flash('pesan', Yoga::gagalFlash('Tidak bisa menghapus pasien karena pasien sedang ada dalam antrian'));
				return false;
			}
		});
	}
	
	public $incrementing = false; 

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $guarded = [];

	public function asuransi(){

		return $this->belongsTo('App\Asuransi');
	}

	public function periksa(){

		return $this->hasMany('App\Periksa');
	}

	public function antrianPeriksa(){

		return $this->hasMany('App\AntrianPeriksa');
	}
	public function antrianPoli(){

		return $this->hasMany('App\AntrianPoli');
	}

	public function registerHamil(){

		return $this->hasMany('App\RegisterHamil');
	}
	public function getNamaAttribute($nama){
		return ucwords( strtolower($nama) );
	}
	public function getAlamatAttribute($alamat){

		return ucwords( strtolower($alamat) );

	}

	public function setNamaAttribute($value) {

        $this->attributes['nama'] = strtolower($value);

    }
	public function setAlamatAttribute($value) {

        $this->attributes['alamat'] = strtolower($value);

    }

	public function getTensisAttribute(){
		$periksas = $this->periksa;
		$jumlah = 0;
		$temp = '<ul>';
		foreach ($periksas as $px) {
			$pretd = explode("mmHg",$px->pemeriksaan_fisik)[0];
			$diastolik = '';
			try {
				$tensi = filter_var(explode("/",$pretd)[1], FILTER_SANITIZE_NUMBER_INT);
				if ($tensi < 200) {
					$diastolik = $tensi;
				}
			} catch (\Exception $e) {

			}

			$tensi = filter_var(explode("/",$pretd)[0], FILTER_SANITIZE_NUMBER_INT);
			if ($tensi < 300) {
				$temp .= '<li>' .$tensi . '/' . $diastolik . '</li>';
			}
		}
		$temp .= '</ul>';
		return $temp;
	}
	public function getRatatensiAttribute(){
		$periksas = $this->periksa;
		$sistolik = 0;
		$jumlah =0;
		foreach ($periksas as $px) {
			$pretd = explode("mmHg",$px->pemeriksaan_fisik)[0];
			$tensi = filter_var(explode("/",$pretd)[0], FILTER_SANITIZE_NUMBER_INT);
			if ($tensi < 300 && $tensi != '') {
				$sistolik += $tensi;
				$jumlah++;
			}
		}

		if ($jumlah == 0) {
			$jumlah = 1;
		}
		if ($jumlah > 2) {
			return $sistolik/$jumlah;
		} else {
			 return null;
		}

	}

	public function getAdadmAttribute(){
		$id = $this->id;
		$query = "SELECT count(*) as jumlah FROM periksas as px join diagnosas as dg on dg.id = px.diagnosa_id where dg.diagnosa like '%dm tipe 2%' and px.pasien_id='{$id}'";
		$jumlah = DB::select($query)[0]->jumlah;
		if ($jumlah > 2) {
			return 'golongan DM ' . 'didiagnosa dm sebanyak' . ' ' . $jumlah . ' kali';
		}
		return 'bukan DM';
	}
	public function getRiwgdsAttribute(){
		$id = $this->id;
		$query = "SELECT * FROM periksas as px join diagnosas as dg on dg.id = px.diagnosa_id join transaksi_periksas as tx on tx.periksa_id = px.id where dg.diagnosa like '%dm tipe 2%' and px.pasien_id='{$id}' and tx.jenis_tarif_id=116 group by px.id";
		$temp ='<ul>';
		$periksas = DB::select($query);
		foreach ($periksas as $px) {
			$temp .= '<li>' . $px->pemeriksaan_penunjang .  '</li>';
		}
		$temp .='</ul>';
		return $temp;
	}
	
}
