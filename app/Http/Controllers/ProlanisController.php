<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Pasien;
use DB;

class ProlanisController extends Controller
{
	public function index(){
		$pasien_ids = [];

		// Dapatkan pasien hipertensi lebih dari 3 x pemerikssaan dengan usia diatas 49 tahun
		$query = "select ps.id as pasien_id, count(*) as jumlah, ps.nama as nama_pasien, px.pemeriksaan_fisik as pf, ps.alamat as alamat, ps.no_telp as no_hp, TIMESTAMPDIFF(YEAR, ps.tanggal_lahir, CURDATE()) as age, px.pemeriksaan_penunjang as lab from periksas as px join pasiens as ps on ps.id = px.pasien_id where TIMESTAMPDIFF(YEAR, ps.tanggal_lahir, CURDATE()) > 49 and px.asuransi_id=32 and ((  pemeriksaan_fisik like '%mmHg%' and pemeriksaan_fisik like '%/%'  ) or (px.pemeriksaan_penunjang like '%gds%') ) group by pasien_id;";
		$datas = DB::select($query);
		$prolanis = [];
		foreach ($datas as $data) {
			$pretd = explode("mmHg",$data->pf)[0];
			$sistolik = filter_var(explode("/",$pretd)[0], FILTER_SANITIZE_NUMBER_INT);
			if (( $sistolik > 139 and $data->jumlah >2 ) or strpos($data->lab, 'gds')) {
				$pasien_ids[] = $data->pasien_id;
			}
		}


		// Dapatkan pasien hipertensi lebih dari 3 x pemerikssaan dengan usia diatas 49 tahun
		$query = "select ps.id as pasien_id, count(*) as jumlah, ps.nama as nama_pasien, px.pemeriksaan_fisik as pf, ps.alamat as alamat, ps.no_telp as no_hp, TIMESTAMPDIFF(YEAR, ps.tanggal_lahir, CURDATE()) as age, px.pemeriksaan_penunjang as lab from periksas as px join diagnosas as dg on dg.id = px.diagnosa_id join pasiens as ps on ps.id = px.pasien_id where px.asuransi_id=32 and TIMESTAMPDIFF(YEAR, ps.tanggal_lahir, CURDATE()) > 49 and dg.diagnosa like '%dm tipe 2%' group by ps.id;";

		$dms = DB::select($query);

		foreach ($dms as $data) {
			if ($data->jumlah > 2) {
				$pasien_ids[] = $data->pasien_id;
			}
		}

		$pasien_ids =  array_unique($pasien_ids);

		$prolanis = Pasien::whereIn('id', $pasien_ids)->get();

		return view('prolanis.index', compact('prolanis'));
	}
	
}
