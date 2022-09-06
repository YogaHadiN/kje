<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Session;
use Storage;
use DB;
use Input;
use Image;
use App\Models\Classes\Yoga;
use Carbon\Carbon;

class Pasien extends Model{
    use BelongsToTenant,HasFactory;
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
	
	// Add your validation rules here

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $guarded = [];

	public function asuransi(){
		return $this->belongsTo('App\Models\Asuransi');
	}

	public function periksa(){
		return $this->hasMany('App\Models\Periksa');
	}

	public function antrianPeriksa(){
		return $this->hasMany('App\Models\AntrianPeriksa');
	}
	public function antrianPoli(){
		return $this->hasMany('App\Models\AntrianPoli');
	}
	public function registerHamil(){
		return $this->hasMany('App\Models\RegisterHamil');
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
		$jumlah   = 0;
		foreach ($periksas as $px) {
			$pretd = explode("mmHg",$px->pemeriksaan_fisik)[0];
			$tensi = filter_var(explode("/",$pretd)[0], FILTER_SANITIZE_NUMBER_INT);
			return $tensi;
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
		$query = "SELECT count(*) as jumlah ";
		$query .= "FROM periksas as px ";
		$query .= "join diagnosas as dg on dg.id = px.diagnosa_id ";
		$query .= "where dg.diagnosa like '%dm tipe 2%' ";
		$query .= "and px.tenant_id = " . session()->get('tenant_id') . " ";
		$query .= "and px.pasien_id='{$id}'";
		$jumlah = DB::select($query)[0]->jumlah;
		if ($jumlah > 2) {
			return 'golongan DM ' . 'didiagnosa dm sebanyak' . ' ' . $jumlah . ' kali';
		}
		return 'bukan DM';
	}
	public function getRiwgdsAttribute(){
		$pemeriksaan_gulas = '';
		foreach ($this->periksa as $px) {
			foreach ($px->transaksii as $trx) {
				if ( $trx->jenis_tarif_id ==  JenisTarif::where('jenis_tarif', 'Gula Darah')->first()->id) {
					$pemeriksaan_gulas .= '<li>' . $px->pemeriksaan_penunjang . '</li>';
					break;
				}
			}
		}
		return $pemeriksaan_gulas;
	}
	
	public function imageUpload($pre, $fieldName, $id){
		if(Input::hasFile($fieldName)) {

			$upload_cover = Input::file($fieldName);
			/* dd( $upload_cover ); */
			//mengambil extension
			$extension = $upload_cover->getClientOriginalExtension();

			/* $upload_cover = Image::make($upload_cover); */
			/* $upload_cover->resize(1000, null, function ($constraint) { */
			/* 	$constraint->aspectRatio(); */
			/* 	$constraint->upsize(); */
			/* }); */

			//membuat nama file random + extension
			$filename =	 $pre . $id . '_' .  time().'.' . $extension;

			//menyimpan bpjs_image ke folder public/img
			$destination_path =  'img/pasien/';

			//destinasi s3
			//
			Storage::disk('s3')->put($destination_path. $filename, file_get_contents($upload_cover));
			// Mengambil file yang di upload

			/* $upload_cover->save($destination_path . '/' . $filename); */
			
			//mengisi field bpjs_image di book dengan filename yang baru dibuat
			return 'img/pasien/'. $filename;
			
		} else {
			return null;
		}
	}
	public function imageUploadWajah($pre, $fieldName, $id){
		if(Input::hasFile($fieldName)) {

			$upload_cover = Input::file($fieldName);
			//mengambil extension
			$extension = $upload_cover->getClientOriginalExtension();

			/* $upload_cover = Image::make($upload_cover); */
			/* $upload_cover->fit(800, 600, function ($constraint) { */
			/* 	$constraint->upsize(); */
			/* }); */

			//membuat nama file random + extension
			$filename =	 $pre . $id . '_' . time() . '.' . $extension;

			/* dd( $filename ); */
			//menyimpan bpjs_image ke folder public/img
			$destination_path = 'img/pasien/';
			/* $destination_path = public_path() . DIRECTORY_SEPARATOR . 'img/pasien/'; */
			// Mengambil file yang di upload

			/* $upload_cover->save($destination_path . '/' . $filename); */

			/* dd( $destination_path . $filename ); */
			Storage::disk('s3')->put( $destination_path. $filename, file_get_contents($upload_cover));
			
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
	
	public function prolanis(){
        return $this->hasOne('App\Models\Prolanis', 'pasien_id');
	}
	
	public function getIsGolonganProlanis(){
		if (isset(  $this->prolanis  )) {
			return true;
		}
		return false;
	}
	public function getUsiaAttribute(){
		if (!empty( $this->tanggal_lahir )) {
			return Yoga::umurSaatPeriksa($this->tanggal_lahir, date('Y-m-d H:i:s'));
		} else {
			return 0;
		}
	}
	public function alergies(){
		return $this->hasMany('App\Models\Alergi');
	}
	public function getTanggalLahirAttribute($nama){
		return empty($nama)? Carbon::parse(date('Y-m-d')) : Carbon::parse($nama);
	}

	public function role(){
		return $this->belongsTo('App\Models\Role');
	}
    public static function sudahPeriksaGDSBulanIniPakaiBPJS($pasien_id, $periksa_id = null){
        $bulanIni = date('Y-m');
        $query  = "SELECT pemeriksaan_penunjang ";
        $query .= "FROM periksas as prx ";
        $query .= "JOIN asuransis as asu on asu.id = prx.asuransi_id ";
        $query .= "WHERE tanggal like '{$bulanIni}%' ";
        $query .= "AND prx.pasien_id  =  " . $pasien_id . " ";
        if (isset ($periksa_id)) {
            $query .= "AND prx.id < " . $periksa_id . " ";
        }
        $query .= "AND prx.pemeriksaan_penunjang like '%Gula Darah%';";
        
        if ( count( DB::select($query) ) ) {
            return true;
        }
        return false;
    }

    public function getPeriksaTerakhirAttribute(){
        return Periksa::where('pasien_id', $this->id)->orderBy('id', 'desc')->first();
    }
    public function keluarga(){
        return $this->belongsTo('App\Models\Keluarga');
    }
}
