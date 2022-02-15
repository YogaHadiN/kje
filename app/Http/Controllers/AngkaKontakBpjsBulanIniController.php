<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Input;
use DB;
use App\Http\Controllers\AngkaKontakController;
use App\Http\Controllers\KunjunganSakitController;
use App\Http\Controllers\KunjunganSehatController;
use App\Http\Controllers\HomeVisitController;

class AngkaKontakBpjsBulanIniController extends Controller
{
	public $input_nama;
	public $input_tanggal;
	public $input_nomor_asuransi_bpjs;
	public $input_no_telp;
	public $input_displayed_rows;
	public $input_key;
	public $input_bulan;
	public $input_tahun;

	/**
	* @param 
	*/

	public function __construct()
	{
		$this->input_nama                = Input::get('nama');
		$this->input_tanggal             = Input::get('tanggal');
		$this->input_nomor_asuransi_bpjs = Input::get('nomor_asuransi_bpjs');
		$this->input_no_telp             = Input::get('no_telp');
		$this->input_displayed_rows      = Input::get('displayed_rows');
		$this->input_key                 = Input::get('key');
	}
	
	public function searchAjax(){

		$tahun           = date('Y');
		$bulan           = date('m');
		/* dd($bulan); */

		$ak              = new AngkaKontakController;
		$ak->input_tahun = $tahun;
		$ak->input_bulan = $bulan;
		$dataAk          = $ak->searchAjax();

		$ks              = new KunjunganSakitController;
		$ks->input_tahun = $tahun;
		$ks->input_bulan = $bulan;
		$dataKs          = $ks->searchAjax();

		$pg              = new KunjunganSehatController;
		$pg->input_tahun = $tahun;
		$pg->input_bulan = $bulan;
		$dataPg          = $pg->searchAjax();

		$hv              = new HomeVisitController;
		$hv->input_tahun = $tahun;
		$hv->input_bulan = $bulan;
		$dataHv          = $hv->searchAjax();

		$resultData = array_merge($dataAk['data'], $dataKs['data'], $dataPg['data'], $dataHv['data']);
		$resultData = array_slice( $resultData, 0, $this->input_displayed_rows, true );
		$resultPage = (int)$dataAk['pages']+(int) $dataKs['pages']+(int) $dataPg['pages']+(int) $dataHv['pages'];
		$resultRows = (int)$dataAk['rows']+(int) $dataKs['rows']+(int) $dataPg['rows']+(int) $dataHv['rows'];
		$key        = $dataAk['key'];

		return [
			'data'  => $resultData,
			'pages' => $resultPage,
			'rows'  => $resultRows,
			'key'   => $this->input_key
		];
	}
}
