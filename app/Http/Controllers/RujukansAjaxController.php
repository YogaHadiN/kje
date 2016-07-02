<?php

namespace App\Http\Controllers;

use Input;

use App\Http\Requests;

use App\RumahSakit;
use App\TujuanRujuk;
use DB;

class RujukansAjaxController extends Controller
{

	public function rs(){

		$jenis_rumah_sakit = Input::get('tipe_rumah_sakit_id');

		$data = RumahSakit::where('jenis_rumah_sakit', $jenis_rumah_sakit)->get(['nama']);
		$rumah_sakit = [];
		foreach ($data as $key => $value) {
			$rumah_sakit[] = $value['nama'];
		}
		return json_encode($rumah_sakit);

	}
	public function tujurujuk(){

		$tujuan_rujuk = trim(Input::get('tujuan_rujuk'));
		$asuransi_id = trim(Input::get('asuransi_id'));


		if(!empty($tujuan_rujuk)){

			$tujuanRujuk = TujuanRujuk::where('tujuan_rujuk', $tujuan_rujuk)->first();

			if ($tujuanRujuk) {
				$tujuan_rujuk_id = $tujuanRujuk->id;
			} else {
				$tj = new TujuanRujuk;
				$tj->tujuan_rujuk = $tujuan_rujuk;
				$tj->save();

				$tujuan_rujuk_id = $tj->id;
			}
			if ($asuransi_id == '32') {
				$query = "SELECT rs.nama as nama, ry.rayon as rayon, jrs.jenis_rumah_sakit, rs.tipe_rumah_sakit FROM tujuan_rujuks as tr join fasilitas as fs on fs.tujuan_rujuk_id = tr.id join rumah_sakits as rs on rs.id=fs.rumah_sakit_id join rayons as ry on ry.id = rs.rayon_id join jenis_rumah_sakits as jrs on jrs.id = rs.jenis_rumah_sakit WHERE ";
				$query .= "tr.id = '{$tujuan_rujuk_id}' and rs.bpjs = 1";
				$query .= ' order by rs.rayon_id asc, rs.tipe_rumah_sakit desc;';
			} else {
				$query = "SELECT rs.nama as nama, ry.rayon as rayon, jrs.jenis_rumah_sakit, rs.tipe_rumah_sakit FROM tujuan_rujuks as tr join fasilitas as fs on fs.tujuan_rujuk_id = tr.id join rumah_sakits as rs on rs.id=fs.rumah_sakit_id join rayons as ry on ry.id = rs.rayon_id join jenis_rumah_sakits as jrs on jrs.id = rs.jenis_rumah_sakit WHERE ";
				$query .= "tr.id = '{$tujuan_rujuk_id}'";
				$query .= ' order by rs.rayon_id asc, rs.tipe_rumah_sakit desc;';
			}
			return DB::select($query);
		}
	}

	public function rschange(){
		$rumah_sakit = Input::get('rumah_sakit');
		return RumahSakit::where('nama', $rumah_sakit)->first();
	}

}