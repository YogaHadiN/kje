<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Classes\Yoga;
use App\Models\Pasien;
use App\Models\DeletedPeriksa;
use App\Models\PasienRujukBalik;
use App\Models\Alergi;
use App\Models\HomeVisit;
use App\Models\AntrianPeriksa;
use App\Models\AntrianPoli;
use App\Models\Complain;
use App\Models\FacebookDaftar;
use App\Models\Kabur;
use App\Models\Periksa;
use App\Models\Prolanis;
use App\Models\RegisterHamil;
use App\Models\SmsBpjs;
use App\Models\SmsGagal;
use App\Models\SmsJangan;
use App\Models\SmsKontak;
use Input;
use DB;

class PasiensMergeController extends Controller
{
	public function index(){
		$ps               = new Pasien;
		$statusPernikahan = $ps->statusPernikahan();
		$panggilan        = $ps->panggilan();
		$asuransi         = Yoga::asuransiList();
		$jenis_peserta    = $ps->jenisPeserta();
		$staf             = Yoga::stafList();
		$poli             = Yoga::poliList();
		$peserta          = [ null => '- Pilih -', '0' => 'Peserta Klinik', '1' => 'Bukan Peserta Klinik'];
		return view('pasiens.merge')
			->withAsuransi($asuransi)
			->with('statusPernikahan', $statusPernikahan)
			->with('panggilan', $panggilan)
			->with('peserta', $peserta)
			->with('jenis_peserta', $jenis_peserta)
			->withStaf($staf)
			->withPoli($poli);
	}
	public function searchPasien(){
		$q = Input::get('q');

		$words = explode(";", $q);
		$tanggal = Yoga::updateDatePrep($q);
		$query  = "SELECT ps.image as image, ";
		$query .= "ps.id as id, ";
		$query .= "ps.alamat as alamat, ";
		$query .= "ps.nama as nama_pasien, ";
		$query .= "ps.no_telp as no_telp, ";
		$query .= "ps.tanggal_lahir as tanggal_lahir, ";
		$query .= "asu.nama as nama_asuransi FROM ";
		$query .= "pasiens as ps join asuransis as asu on asu.id=ps.asuransi_id ";
		$query .= "WHERE ";
		foreach ($words as $word) {
			$params = '%';
			foreach (str_split($word) as $w) {
				$params .= $w. '%';
			}
			$query .= "(DATE_FORMAT(tanggal_lahir,'%m-%d-%Y') like '" . $params. "' or ";
			$query .= "ps.nama like '" . $params. "' or ";
			$query .= "ps.alamat like '" . $params. "') AND ";
		}
		$query .= "AND ps.tenant_id = " . session()->get('tenant_id') . " ";
		$query .= 'Limit 10';
		$pasiens = DB::select($query);
		$datas = [];
		foreach ($pasiens as $pasien) {
			$datas['items'][] = [
				'owner' => [
					'avatar_url' => $pasien->image
				],
				'id'               => $pasien->id,
				'description'      => $pasien->alamat,
				'full_name'        => $pasien->nama_pasien,
				'forks_count'      => $pasien->no_telp,
				'stargazers_count' => Yoga::updateDatePrep( $pasien->tanggal_lahir ),
				'watchers_count'   => $pasien->nama_asuransi
			];
		}
		return $datas;
	
	}
	public function cariPasien(){
		$pasien_id = Input::get('pasien_id');
		$query  = "SELECT * from pasiens ";
		$query .= "WHERE id='" .$pasien_id . "' ";
		$query .= "AND tenant_id = " . session()->get('tenant_id') . " ";
		$data = DB::select($query)[0];
		
		return json_encode( $data );
	}
	public function cariPasienPost(){
		DB::beginTransaction();
		try {
			$pasiens = json_decode( Input::get('tempArray'), true );
			$hapusId = [];
			$deleteId = '';
			foreach ($pasiens as $k => $p) {
				if ($k > 0) {
					$hapusId[] = $p['id'];
					$deleteId .= "," .  "'" . $p['id'].  "'";
				} else {
					$deleteId      .= "'" . $p['id'] . "'";
					$pertahankanID  = $p['id'];
				}
			}

			$query  = "select * from INFORMATION_SCHEMA.COLUMNS where COLUMN_NAME like 'pasien_id' and table_schema = 'jatielok' order by TABLE_NAME";
			$tables = DB::select($query);

			foreach ($tables as $t) {
				$query  = "UPDATE " . $t->TABLE_NAME . " set pasien_id = '{$pertahankanID}' where pasien_id in ({$deleteId}) ";
				DB::statement($query);
			}

			$query  = "UPDATE pengantar_pasiens set pengantar_id = '{$pertahankanID}' where pengantar_id in ({$deleteId}) ";
			DB::statement($query);

			$confirm_pasien_hapus = Pasien::destroy($hapusId);

			$pesan = Yoga::suksesFlash('Pasien berhasil digabung');
			DB::commit();
			return redirect()->back()->withPesan($pesan);
		} catch (\Exception $e) {
			DB::rollback();
			throw $e;
		}
	}

	public function queryTables(){
		$query  = "select TABLE_NAME from INFORMATION_SCHEMA.COLUMNS ";
		$query .= "where COLUMN_NAME like 'pasien_id' ";
		$query .= "and table_schema like 'jatielok' ";
		$query .= "order by TABLE_NAME ";
		return DB::select($query);
	}
	
}
