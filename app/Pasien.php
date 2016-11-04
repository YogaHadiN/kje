<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Session;
use DB;
use Input;
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
	
	public function imageUpload($pre, $fieldName, $id){
		if(Input::hasFile($fieldName)) {

			$upload_cover = Input::file($fieldName);
			//mengambil extension
			$extension = $upload_cover->getClientOriginalExtension();

			//membuat nama file random + extension
			$filename =	 $pre . $id . '.' . $extension;

			//menyimpan bpjs_image ke folder public/img
			$destination_path = public_path() . DIRECTORY_SEPARATOR . 'img/pasien';

			// Mengambil file yang di upload
			$upload_cover->move($destination_path, $filename);
			
			//mengisi field bpjs_image di book dengan filename yang baru dibuat
			return 'img/pasien/'. $filename;
			
		} else {
			return null;
		}

	}

	public function statusPernikahan(){
		return array( 
			null => '- Status Pernikahan -',
			'Pernah' => 'Pernah Menikah',
			'Belum' => 'Belum Menikah'
		);
	}
	public function panggilan(){
		return array(
					null => '-Panggilan-',
					'Tn' => 'Tn (Laki dewasa)',
					'Ny' => 'Ny (Wanita Dewasa Menikah)',
					'Nn' => 'Nn (Wanita Dewasa Belum Menikah)',
					'An' => 'An (Anak-anak diatas 3 tahun)',
					'By' => 'By (Anak2 dibawah 3 tahun)'
					);
	
	}
	
	public function jenisPeserta(){
		return array(
					null => ' - pilih asuransi -',  
		            "P" => 'Peserta',
		            "S" => 'Suami',
		            "I" => 'Istri',
		            "A" => 'Anak'
		);
	}

	public function prolanis(){
        return $this->hasOne('App\Prolanis', 'pasien_id');
	}
	
	public function getIsGolonganProlanis(){
		if (isset(  $this->prolanis  )) {
			return true;
		}
		return false;
	}
	
}
