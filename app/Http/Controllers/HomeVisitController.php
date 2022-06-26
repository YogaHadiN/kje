<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Input;
use Image;
use Storage;
use App\Models\Pasien;
use App\Models\Classes\Yoga;
use App\Models\HomeVisit;
use DB;

class HomeVisitController extends Controller
{
	public $input_nama;
	public $input_tanggal;
	public $input_nomor_asuransi_bpjs;
	public $input_key;
	public $input_displayed_rows;
	public $pasien_id;
	public $sistolik;
	public $diastolik;
	public $berat_badan;
	public $hasFile;
	public $file;
	public $input_bulan;
	public $input_tahun;
	public $input_no_telp;

	/**
	* @param 
	*/

	public function __construct()
	{
		$this->input_nama                = Input::get('nama');
		$this->input_no_telp             = Input::get('no_telp');
		$this->input_tanggal             = Input::get('tanggal');
		$this->input_nomor_asuransi_bpjs = Input::get('nomor_asuransi_bpjs');
		$this->input_key                 = Input::get('key');
		$this->input_displayed_rows      = Input::get('displayed_rows');
		$this->pasien_id                 = Input::get('pasien_id');
		$this->berat_badan               = Input::get('berat_badan');
		$this->sistolik                  = Input::get('sistolik');
		$this->diastolik                 = Input::get('diastolik');
		$this->hasFile                   = Input::hasFile('image');
		$this->file                      = Input::file('image');

	}

	public function index(){
		return view('home_visits.index');
	}
	public function create(){
		return view('home_visits.create');
	}
	
	public function searchAjax(){
		$data                = $this->queryData();
		$count               = $this->queryData(true)[0]->jumlah;
		$pages               = ceil( $count/ $this->input_displayed_rows );

		return [
			'data'  => $data,
			'pages' => $pages,
			'key'   => $this->input_key,
			'rows'  => $count
		];
	}
	private function queryData($count = false){
		$pass  = $this->input_key * $this->input_displayed_rows;
		if ( isset( $this->input_tahun ) && isset( $this->input_bulan ) ) {
			$bulan_ini = $this->input_tahun . '-' . $this->input_bulan;
		}
		$query = "SELECT ";
		if (!$count) {
			$query .= "ps.nama, ";
			$query .= "ps.nomor_asuransi_bpjs,";
			$query .= "hv.sistolik,";
			$query .= "hv.id as id,";
			$query .= "hv.diastolik,";
			$query .= "hv.berat_badan,";
			$query .= "hv.created_at as tanggal ";
		} else {
			$query .= "count(*) as jumlah ";
		}
		$query .= "FROM home_visits as hv ";
		$query .= "JOIN pasiens as ps on ps.id = hv.pasien_id ";
		$query .= "WHERE ";
		$query .= "(hv.created_at like '%{$this->input_tanggal}%') ";
		$query .= "AND (ps.nama like '%{$this->input_nama}%') ";
		$query .= "AND hv.tenant_id = " . session()->get('tenant_id') . " ";
		$query .= "AND (ps.no_telp like '%{$this->input_no_telp}%') ";
		if (isset( $bulan_ini )) {
			$query .= "AND (hv.created_at like '{$bulan_ini}%')  ";
		}
		$query .= "AND (ps.nomor_asuransi_bpjs like '%{$this->input_nomor_asuransi_bpjs}%' or nomor_asuransi_bpjs is null) ";

		/* dd( $query ); */
		/* $query .= "GROUP BY px.pasien_id "; */
		/* $query .= "GROUP BY p.id "; */
		/* $query .= "ORDER BY dg.created_at DESC "; */

		if (!$count) {
			$query .= "LIMIT {$pass}, {$this->input_displayed_rows} ";
		}
		return DB::select($query);
	}
	public function createPasien($id){
		$pasien = Pasien::find( $id );
		/* dd($pasien); */
		return view('home_visits.createPasien', compact(
			'pasien'
		));
	}

	public function edit($id){
		$home_visit = HomeVisit::find( $id );
		/* dd($pasien); */
		return view('home_visits.edit', compact(
			'home_visit'
		));
	}
	public function store(){
		$home_visit              = new HomeVisit;
		$this->inputData($home_visit);

		$pesan = Yoga::suksesFlash('Home Visit Berhasil ditambahkan');
		return redirect('home_visits')->withPesan($pesan);
	}
	public function update($id){
		$home_visit              = HomeVisit::find($id);
		$this->inputData($home_visit);

		$pesan = Yoga::suksesFlash('Home Visit Berhasil diupdate');
		return redirect('home_visits')->withPesan($pesan);
	}
	
	private function imageUpload($pre, $fieldName, $staf){
		if( $this->hasFile ) {

			$upload_cover = $this->file;
			//mengambil extension
			$extension = $upload_cover->getClientOriginalExtension();

			/* $upload_cover = Image::make($upload_cover); */
			/* $upload_cover->resize(1000, null, function ($constraint) { */
			/* 	$constraint->aspectRatio(); */
			/* 	$constraint->upsize(); */
			/* }); */
			$folder =  'img/home_visit/';
			//membuat nama file random + extension
			$filename =	 $folder .  $pre . $staf->id . '_' . time() . '.' . $extension;

			//menyimpan bpjs_image ke folder public/img
			/* $destination_path = public_path() . DIRECTORY_SEPARATOR; */

			// Mengambil file yang di upload
			//
			//
			//
			/* $upload_cover->save($destination_path . '/' . $filename); */
			
			Storage::disk('s3')->put( $filename, file_get_contents($upload_cover));
			//mengisi field bpjs_image di book dengan filename yang baru dibuat
			return $filename;
			
		} else {
			return $staf->$fieldName;
		}

	}
	
	public function inputData($home_visit){

		$home_visit->pasien_id   = $this->pasien_id;
		$home_visit->sistolik    = $this->sistolik;
		$home_visit->diastolik   = $this->diastolik;
		$home_visit->berat_badan = $this->berat_badan;
		$home_visit->save();
		$home_visit->image = $this->imageUpload('home_visit', 'image', $home_visit);
		$home_visit->save();

		$pasien                         = $home_visit->pasien;
		$pasien->sudah_kontak_bulan_ini = 1;
		$pasien->save();
	}
	public function destroy($id){

		HomeVisit::destroy( $id );
		$pesan = Yoga::suksesFlash('berhasil dihapus');
		return redirect('home_visits')->withPesan($pesan);

	}
	
	
}
