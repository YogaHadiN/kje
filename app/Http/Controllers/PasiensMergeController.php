<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Classes\Yoga;
use App\Pasien;
use App\AntrianPeriksa;
use App\AntrianPoli;
use App\Complain;
use App\FacebookDaftar;
use App\Kabur;
use App\Periksa;
use App\Prolanis;
use App\RegisterHamil;
use App\SmsBpjs;
use App\SmsGagal;
use App\SmsJangan;
use App\SmsKontak;
use Input;
use DB;

class PasiensMergeController extends Controller
{
	public function index(){
		$ps = new Pasien;
		$statusPernikahan = $ps->statusPernikahan();
		$panggilan = $ps->panggilan();
		$asuransi = Yoga::asuransiList();
		$jenis_peserta = $ps->jenisPeserta();
		$staf = Yoga::stafList();
		$poli = Yoga::poliList();
		$peserta = [ null => '- Pilih -', '0' => 'Peserta Klinik', '1' => 'Bukan Peserta Klinik'];
		return view('pasiens.merge')
			->withAsuransi($asuransi)
			->with('statusPernikahan', $statusPernikahan)
			->with('panggilan', $panggilan)
			->with('peserta', $peserta)
			->withJenis_peserta($jenis_peserta)
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
		$query .= '1 = 1 ';
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
		$data = DB::select($query)[0];
		
		return json_encode( $data );
	}
	public function cariPasienPost(){

		$pasiens = json_decode( Input::get('tempArray'), true );
		$hapusId = [];
		foreach ($pasiens as $k => $p) {
			if ($k > 0) {
				$hapusId[] = $p['id'];
			} else {
				$pertahankanID = $p['id'];
			}
		}

		$confirm = AntrianPeriksa::whereIn('pasien_id', $hapusId )->update([
			'pasien_id' => $pertahankanID
		]);
		$confirm = AntrianPoli::whereIn('pasien_id', $hapusId )->update([
			'pasien_id' => $pertahankanID
		]);
		$confirm = Complain::whereIn('pasien_id', $hapusId )->update([
			'pasien_id' => $pertahankanID
		]);
		$confirm = FacebookDaftar::whereIn('pasien_id', $hapusId )->update([
			'pasien_id' => $pertahankanID
		]);
		$confirm = Kabur::whereIn('pasien_id', $hapusId )->update([
			'pasien_id' => $pertahankanID
		]);
		$confirm = Periksa::whereIn('pasien_id', $hapusId )->update([
			'pasien_id' => $pertahankanID
		]);
		$confirm = Prolanis::whereIn('pasien_id', $hapusId )->update([
			'pasien_id' => $pertahankanID
		]);
		$confirm = RegisterHamil::whereIn('pasien_id', $hapusId )->update([
			'pasien_id' => $pertahankanID
		]);
		$confirm_sms_bpjs = SmsBpjs::whereIn('pasien_id', $hapusId )->update([
			'pasien_id' => $pertahankanID
		]);
		$confirm_sms_gagal = SmsGagal::whereIn('pasien_id', $hapusId )->update([
			'pasien_id' => $pertahankanID
		]);
		$confirm_sms_jangan = SmsJangan::whereIn('pasien_id', $hapusId )->update([
			'pasien_id' => $pertahankanID
		]);
		$confirm_sms_kontak = SmsKontak::whereIn('pasien_id', $hapusId )->update([
			'pasien_id' => $pertahankanID
		]);
		$confirm_pasien_hapus = Pasien::destroy($hapusId);

		$pesan = Yoga::suksesFlash('Pasien berhasil digabung');
		return redirect('pasiens')->withPesan($pesan);

	}
}
