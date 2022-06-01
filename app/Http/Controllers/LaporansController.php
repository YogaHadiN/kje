<?php

namespace App\Http\Controllers;

use Input;
use Auth;
use Carbon\Carbon;
use App\Models\Classes\Yoga;
use DB;
use App\Http\Controllers\AsuransisController;
use App\Http\Controllers\PdfsController;
use App\Http\Controllers\PasiensController;
use App\Http\Requests;
use App\Models\AkunBank;
use App\Models\DenominatorBpjs;
use App\Models\PesertaBpjsPerbulan;
use App\Models\Config;
use App\Models\Asuransi;
use App\Models\AntrianPeriksa;
use App\Models\Periksa;
use App\Models\BayarDokter;
use App\Models\BayarGaji;
use App\Models\TransaksiPeriksa;
use App\Models\PembayaranAsuransi;
use App\Models\Staf;
use App\Models\JurnalUmum;
use App\Models\NotaJual;
use App\Models\Coa;
use App\Models\FakturBelanja;
use App\Models\SmsBpjs;
use App\Models\PcareSubmit;
use App\Models\PengantarPasien;
use App\Models\Terapi;
use App\Models\SmsKontak;
use App\Models\SmsGagal;
use App\Models\AntrianPoli;
use App\Models\JenisTarif;
use App\Models\KunjunganSakit;
use App\Models\TipeLaporanAdmedika;
use App\Models\TipeLaporanKasir;
use App\Models\Rak;
use App\Models\Pendapatan;

class LaporansController extends Controller
{
	public function __construct()
	 {
		 $this->middleware('super', ['only' => [
			 'payment',
			 'paymentpost',
			 'pendapatan',
			 'omsetEstetik',
			 'status'
		 ]]);
	 }

	public function bpjsTidakTerpakai(){
		$tanggall = Input::get('bulanTahun');
		$tanggal  = Yoga::blnPrep($tanggall);

		$kunjungan_sakits = KunjunganSakit::with(
			'periksa.pasien', 
			'periksa.asuransi', 
			'periksa.diagnosa.icd10', 
			'periksa.terapii.merek'
		)
			->where('created_at', 'like', $tanggal . '%')
			/* ->whereRaw('(pcare_submit = 0 or pcare_submit = 2)') */
			->orderBy('pcare_submit')
			->get();

		$ks = [];
		$ksSubmit = [];
		foreach ($kunjungan_sakits as $v) {
			if (
				$v->pcare_submit == 0 ||
				$v->pcare_submit == 2
			) {
				$ks[] = $v;
			} else if (
				$v->pcare_submit == 1 ||
				$v->pcare_submit == 3
			) {
				$ksSubmit[] = $v;
			}
		}

		$pcare_submits =  PcareSubmit::pluck('pcare_submit', 'id');
		return view('laporans.bpjs_tidak_terpakai', compact(
			'pcare_submits',
			'ksSubmit',
			'ks'
		));
	}
	public function pengantar(){
		$tanggal                = date('Y-m');
		$pp                     = PengantarPasien::where('created_at', 'like', $tanggal . '%')->where('pcare_submit', 0)->latest()->get();
		$periksa_id_bulan_ini   = $this->extractId(Periksa::where('tanggal', 'like', $tanggal . '%')->get(['pasien_id']), 'pasien_id');
		$pengantar_id_bulan_ini = $this->extractId(PengantarPasien::where('created_at', 'like', $tanggal . '%')->where('pcare_submit', '1')->get(['pengantar_id']), 'pengantar_id');
		$arrays = array_merge($periksa_id_bulan_ini, $pengantar_id_bulan_ini);

		$adf = PengantarPasien::whereIn('pengantar_id', $arrays) // hapus pengantar id yang memiliki id ini
			->where('created_at', 'like', $tanggal.'%') // dan diinput bulan ini
			->where('pcare_submit', '0') // dan belum dimasukkan dalam pcare
			->update([
				'kunjungan_sehat' => 0 // update kunjungan sehat menjadi 0
			]);
		$pp_harus_diinput = PengantarPasien::with('pengantar')
											->where('antarable_type', 'App\\Models\\Periksa')
											->whereIn('pcare_submit',[0,2])
											->where('created_at', 'like', $tanggal. '%')
											->where('kunjungan_sehat', '1')
											->groupBy('pengantar_id')
											->orderBy('pcare_submit', 'asc')
											->orderBy('created_at', 'desc')
											->paginate(10);


		$pp_sudah_diinput = PengantarPasien::with('pengantar')
											->where('antarable_type', 'App\\Models\\Periksa')
											->where('pcare_submit',1)
											->where('created_at', 'like', $tanggal. '%')
											->groupBy('pengantar_id')
											->orderBy('pcare_submit', 'asc')
											->orderBy('created_at', 'desc')
											->paginate(10);

		$pcare_submits =  PcareSubmit::pluck('pcare_submit', 'id');

		return view('laporans.pengantar', compact(
			'pp_harus_diinput',
			'pp_sudah_diinput',
			'pcare_submits',
			'tanggal'
		));
	}
	

	public function index() {
		$asuransis      = ['%' => 'SEMUA PEMBAYARAN'] + Asuransi::pluck('nama', 'id')->all();
		$antrianperiksa = AntrianPeriksa::all();
		$antrianbelanja = FakturBelanja::where('submit', '0')->count();
		$nursestation   = AntrianPoli::all();
		$auth           = Auth::user();
		$raklist        = Yoga::rakList();
		$staf           = Yoga::stafList();

		$bulanIni           = date('Y-m');
		$hariIni            = date('Y-m-d');
		$id_bulan_ini       = date('ym');

		$query              = "SELECT *, ";
		$query             .= "asu.nama as nama_asuransi ";
		$query             .= "FROM periksas as prx ";
		$query             .= "LEFT OUTER JOIN asuransis as asu on asu.id = prx.asuransi_id ";
		$query             .= "WHERE prx.tanggal between '{$bulanIni}-01' and '" . date("Y-m-t", strtotime($bulanIni. "-01")) . "' ";

		$periksa_bulan_ini  = DB::select($query);

		$periksa_hari_ini = [];
		foreach ($periksa_bulan_ini as $prx) {
			if (
				$prx->tanggal == date('Y-m-d')
			) {
				$periksa_hari_ini[] = $prx;
			}
		}
		$jumlah_pasien_baru_bulan_ini = 0;
		foreach ($periksa_bulan_ini as $prx) {
			if ( substr($prx->pasien_id, 0, 4) == date('ym') ) {
				$jumlah_pasien_baru_bulan_ini++;
			}
		}

		$total_pasien_bulan_ini       = count($periksa_bulan_ini);
		$jumlah_pasien_lama_bulan_ini = $total_pasien_bulan_ini - $jumlah_pasien_baru_bulan_ini;

		if ($total_pasien_bulan_ini > 0) {
			$persen_pasien_lama_bulan_ini = round( $jumlah_pasien_lama_bulan_ini / $total_pasien_bulan_ini* 100 );
			$persen_pasien_baru_bulan_ini = 100 - $persen_pasien_lama_bulan_ini;
		} else {
			$persen_pasien_lama_bulan_ini=0;
			$persen_pasien_baru_bulan_ini= 0;
		}


		$getHariIni = $this->getHariIni($periksa_hari_ini);
		$hariinis   = $getHariIni['hariinis'];
		$polis      = $getHariIni['polis'];


		/* $periksa_polis = $this->periksaHarian(date('Y-m-d')); // sama kayak periksa_hari_ini */

		$obat_minus             = Rak::where('stok', '<' , -1)->count();
		$obat_kadaluarsa        = Rak::where('exp_date', '<' , date('Y-m-d'))->count();
		$obat_hampir_kadaluarsa = 9;
		$obat_stok_kritis       = 9;
		
		$jumlah = count($periksa_hari_ini);
		$tanggal = date('Y-m-d');

		$sms_angka_kontak = SmsKontak::angkaKontak(date('Y-m'));
		$angka_kontak_saat_ini               = $sms_angka_kontak['angka_kontak_saat_ini'];
		$pengantar_belum_disubmit            = PengantarPasien::where('created_at', 'like', date('Y-m') . '%')
																->where('pcare_submit', '0')
																->where('kunjungan_sehat', '1')
																->count();

		$denominaor_bpjs     = DenominatorBpjs::orderBy('bulanTahun', 'desc')->first();
		$jumlah_peserta_bpjs = $denominaor_bpjs->jumlah_peserta;
		//target peserta bpjs bulan ini adalah 15% dari seluruh peserta
		$target_jumlah_pasien_bpjs_bulan_ini = $jumlah_peserta_bpjs * 0.15;
		// karena target harus dipenuhi tanggal 25 setiap bulannya;
		$target_jumlah_pasien_bpjs_per_hari  = ceil($target_jumlah_pasien_bpjs_bulan_ini / 25);

		$target_jumlah_angka_kontak_hari_ini = (date('d') -1) * $target_jumlah_pasien_bpjs_per_hari;

		$angka_kontak_belum_terpenuhi        = $target_jumlah_angka_kontak_hari_ini - $sms_angka_kontak['angka_kontak_kemarin'];

		$kunjungan_sakit_belum_di_submit = KunjunganSakit::where('created_at', 'like', date('Y-m') . '%')
									->where('pcare_submit', '0')
									->count();;

		$prx                      = new PeriksasController;
		$prx->input_tanggal       = date('Y-m-d');
		$hitungRppt               = $prx->hitungPersentaseRppt();

		$jumlah_denominator_dm    = $denominaor_bpjs->denominator_dm;
		$jumlah_denominator_ht    = $denominaor_bpjs->denominator_ht;

		$jumlah_ht_terkendali     = $hitungRppt['jumlah_ht_terkendali'];
		$persentase_ht_terkendali = $hitungRppt['persentase_ht_terkendali'];

		$jumlah_dm_terkendali     = $hitungRppt['jumlah_dm_terkendali'];
		$persentase_dm_terkendali = $hitungRppt['persentase_dm_terkendali'];
		$rppt = $hitungRppt['rppt'];

		return view('laporans.index', compact(
			'asuransis',
			'antrianperiksa',
			'rppt',
			'antrianbelanja',
			'hariinis',
			'jumlah_denominator_dm',
			'jumlah_denominator_ht',
			'jumlah_ht_terkendali',
			'jumlah_dm_terkendali',
			'persentase_ht_terkendali',
			'persentase_dm_terkendali',
			'jumlah_pasien_lama_bulan_ini',
			'persen_pasien_lama_bulan_ini',
			'jumlah_pasien_baru_bulan_ini',
			'persen_pasien_baru_bulan_ini',
			'jumlah',
			'raklist',
			'auth',
			'staf',
			'polis',
			'tanggal',
			'periksa_hari_ini',
			'angka_kontak_saat_ini',
			'pengantar_belum_disubmit',
			'angka_kontak_belum_terpenuhi',
			'kunjungan_sakit_belum_di_submit',
			'nursestation',
			'obat_minus',
			'obat_kadaluarsa',
			'obat_hampir_kadaluarsa',
			'obat_stok_kritis'
		));
	}
	/**
	* undocumented function
	*
	* @return void
	*/
	public function queryHtTerkendali($bulanThn)
	{
		$query  = "SELECT ";
		$query .= "count(prx.id),";
		$query .= "prx.sistolik,";
		$query .= "prx.diastolik,";
		$query .= "psn.nama,";
		$query .= "psn.prolanis_dm,";
		$query .= "psn.prolanis_ht,";
		$query .= "prx.pemeriksaan_penunjang ";
		$query .= "FROM periksas as prx ";
		$query .= "JOIN pasiens as psn on psn.id = prx.pasien_id ";
		$query .= "WHERE tanggal like '" . $bulanThn. "%'";
		$query .= "AND prx.prolanis_ht = 1 ";
		$query .= "GROUP BY psn.id ";
		$query .= "ORDER BY prx.sistolik asc;";
		return DB::select($query);
	}

	public function queryDmTerkendali($bulanThn)
	{
		$query  = "SELECT ";
		$query .= "psn.nama, ";
		$query .= "psn.tanggal_lahir, ";
		$query .= "psn.alamat, ";
		$query .= "prx.tanggal, ";
		$query .= "trx.jenis_tarif_id, ";
		$query .= "trx.keterangan_pemeriksaan, ";
		$query .= "psn.id as pasien_id, ";
		$query .= "CAST(trx.keterangan_pemeriksaan AS UNSIGNED) as ket_pemeriksaan ";
		$query .= "FROM periksas as prx ";
		$query .= "LEFT JOIN transaksi_periksas as trx on prx.id = trx.periksa_id ";
		$query .= "JOIN pasiens as psn on psn.id = prx.pasien_id ";
		$query .= "WHERE psn.prolanis_dm=1 ";
		$query .= "AND prx.tanggal like '" . $bulanThn. "%' ";
		$query .= "GROUP BY psn.id ";
		$query .= "ORDER BY CAST(trx.keterangan_pemeriksaan AS UNSIGNED) asc";
		return DB::select($query);
	}
	


	public function harian()
	{
		$tanggal       = Yoga::datePrep(Input::get('tanggal'));
		$asuransi_id   = Input::get('asuransi_id');
		$jenis_tarifs  = JenisTarif::all();

		$periksas   = $this->periksaHarian($tanggal, $asuransi_id);
		$getHariIni = $this->getHariIni($periksas);
		$hariinis   = $getHariIni['hariinis'];
		$polis      = $getHariIni['polis'];

		// return $rincian;
		$rincian = [];
		$sama = false;
		foreach ($periksas as $key => $px) {
			$transaksi = $px->transaksi;
			$transaksi = json_decode($transaksi,true);
			// return $px-;
			foreach ($transaksi as $ky => $tr) {
				if (count($rincian) == 0) {
					$rincian[] = $tr['jenis_tarif'];
				} else {
					foreach ($rincian as $k => $rc) {
						if($rc == $tr['jenis_tarif']){
							$sama = true;
							break;
						}
					}
					if (!$sama) {
						$rincian[] = $tr['jenis_tarif'];
					}
					$sama = false;
				}
			}
		}
		$jumlah        = 0;
		$piutangJumlah = 0;
		$tunaiJumlah   = 0;
		$id_hari_ini   = date('ymd', strtotime($tanggal));
		foreach ($periksas as $periksa) {
			$jumlah        += (int) $periksa->tunai + (int) $periksa->piutang;
			$piutangJumlah  = (int) $periksa->piutang;
			$tunaiJumlah    = (int) $periksa->tunai;
		}

		$query  = "SELECT count(id) as jumlah_baru ";
		$query .= "FROM pasiens ";
		$query .= "WHERE id like '{$id_hari_ini}%'";
		$datas  = DB::select($query);

		$pasien_baru = $datas[0]->jumlah_baru;
		if (count($periksas)) {
			$persen_baru = round( ( $pasien_baru / count($periksas) ) *100 );
			$persen_lama = 100 - $persen_baru;
		} else {
			$persen_baru = 0;
			$persen_lama = 0;
		}
		$pasien_lama = count($periksas) - $pasien_baru;
		$list_asuransi = Asuransi::list();


		return view('laporans.harian', compact(
			'periksas',
			'rincian',
			'persen_lama',
			'list_asuransi',
			'persen_baru',
			'pasien_lama',
			'pasien_baru',
			'tanggal',
			'polis',
			'jenis_tarifs',
			'piutangJumlah',
			'hariinis',
			'tunaiJumlah'
		));
	}

	public function haridet()
	{
		// return Input::all();
		$tanggal = Yoga::datePrep(Input::get('tanggal'));
		$asuransi_id = Input::get('asuransi_id');
		$jenis_tarifs = JenisTarif::all();
		$periksas = DB::select("SELECT *, ps.nama as nama_pasien, asu.nama as nama_asuransi, p.id as periksa_id, d.icd10_id as icd10 FROM periksas as p LEFT OUTER JOIN pasiens as ps on ps.id = p.pasien_id LEFT OUTER JOIN asuransis as asu on asu.id = p.asuransi_id join diagnosas as d on d.id=p.diagnosa_id where p.tanggal like '{$tanggal}' AND p.asuransi_id like '{$asuransi_id}'");
		$hariinis = DB::select("SELECT asu.nama , count(asuransi_id) as jumlah, asu.id as id FROM periksas as p left outer join asuransis as asu on p.asuransi_id = asu.id where p.tanggal = '" . $tanggal . "' AND asu.id like '" . $asuransi_id . "'  group by asu.nama" );

		$rincian = TipeLaporanAdmedika::all();

		$jumlah = 0;
		$piutangJumlah = 0;
		$tunaiJumlah = 0;

		if ($asuransi_id == '%') {
			$asuransi = 'Semua Pembayaran';
		} else {
			$asuransi = Asuransi::find($asuransi_id)->nama;
		}
		// 

		return view('laporans.haridet')
			->withPeriksas($periksas)
			->withRincian($rincian)
			->withTanggal($tanggal)
			->with('jenis_tarifs', $jenis_tarifs)
			->withAsuransi($asuransi)
			->withPiutangjumlah($piutangJumlah)
			->withHariinis($hariinis)
			->withTunaijumlah($tunaiJumlah);
	}
	public function harikas()
	{
		$tanggal = Yoga::datePrep(Input::get('tanggal'));
		$asuransi_id = Input::get('asuransi_id');
		$jenis_tarifs = JenisTarif::all();
		$periksas = DB::select("SELECT *, ps.nama as nama_pasien, asu.nama as nama_asuransi, p.id as periksa_id, p.transaksi as transaksi FROM periksas as p LEFT OUTER JOIN pasiens as ps on ps.id = p.pasien_id LEFT OUTER JOIN asuransis as asu on asu.id = p.asuransi_id where p.tanggal like '{$tanggal}' AND p.asuransi_id like '{$asuransi_id}'");
		$hariinis = DB::select("SELECT asu.nama , count(asuransi_id) as jumlah, asu.id as id FROM periksas as p left outer join asuransis as asu on p.asuransi_id = asu.id where p.tanggal = '" . $tanggal . "' AND asu.id like '" . $asuransi_id . "'  group by asu.nama" );

		// return $rincian;
		// $rincian = Yoga::rincian($periksas);
		// 
		$rincian = [];
		$tipe_kasirs = TipeLaporanKasir::all();
		$jenis_tarifs = JenisTarif::all();
		foreach ($tipe_kasirs as $key => $tk) {
			$sama = false;
			if (count($rincian) == 0) {
				$rincian[] = [
					'id' => $tk->id,
					'tipe_laporan_kasir' => $tk->tipe_laporan_kasir,
					'nama' => 'yoga'
				];
			} else {
				foreach ($rincian as $ky => $rc) {
					if ($rc['id'] == $tk->id) {
						$sama = true;
					}
					if (!$sama) {
						foreach ($periksas as $k => $prx) {
							$transaksi = $prx->transaksi;
							$transaksi = json_decode($transaksi, true);
							foreach ($transaksi as $i => $tr) {
								$tipe_laporan_kasir_id = $jenis_tarifs->find($tr['jenis_tarif_id'])->tipe_laporan_kasir_id;
								if ($tk->id == $tipe_laporan_kasir_id) {
									$sama = true;
									break;
								}
							}
							if ($sama) {
								break;
							}
						}
					}
				}
				if ($sama) {
					$rincian[] = [
						'id' => $tk->id,
						'tipe_laporan_kasir' => $tk->tipe_laporan_kasir
					];
				}
			}
		}
		// return var_dump($rincian);

		$jumlah = 0;
		$piutangJumlah = 0;
		$tunaiJumlah = 0;

		if ($asuransi_id == '%') {
			$asuransi = 'Semua Pembayaran';
		} else {
			$asuransi = Asuransi::find($asuransi_id)->nama;
		}
		

		return view('laporans.harikas')
			->withPeriksas($periksas)
			->withRincian($rincian)
			->withTanggal($tanggal)
			->with('jenis_tarifs', $jenis_tarifs)
			->withAsuransi($asuransi)
			->withPiutangjumlah($piutangJumlah)
			->withHariinis($hariinis)
			->withTunaijumlah($tunaiJumlah);
	}
	public function bulanan()
	{
		$tanggall = Input::get('bulanTahun');
		$tanggal 		= Yoga::blnPrep($tanggall);
		$asuransi_id 	= Input::get('asuransi_id');

		$query = "SELECT ps.nama as nama_pasien, p.id as periksa_id, s.nama as nama, s.id as id, count(s.id) as jumlah, sum(p.tunai) as tunai, sum(p.piutang) as piutang from periksas as p LEFT OUTER JOIN asuransis as s on s.id = p.asuransi_id join pasiens as ps on ps.id = p.pasien_id where p.tanggal like '{$tanggal}%' AND p.asuransi_id like '{$asuransi_id}' GROUP BY s.nama ORDER BY jumlah desc";
		$bulan = DB::select($query);
		$query = "select count(*) as jumlah from ( SELECT count(pasien_id) as angka_kontak FROM periksas where asuransi_id=32 and tanggal like '$tanggal%' group by pasien_id  ) as x";
		$angka_kontak = DB::select($query)[0]->jumlah;
		$query = "select count(*) as jumlah from ( SELECT * FROM periksas where asuransi_id=32 and tanggal like '$tanggal%' ) as x";
		$angka_kunjungan = DB::select($query)[0]->jumlah;

		$periksa = Periksa::where('tanggal', 'like', $tanggal . '%')->get();
		$rak = Rak::all();
		return view('laporans.bulanan')
			->withRak($rak)
			->withPeriksa($periksa)
			->withTanggal($tanggal)
			->with('asuransi_id', $asuransi_id)
			->withTanggall($tanggall)
			->with('angka_kontak', $angka_kontak)
			->with('angka_kunjungan', $angka_kunjungan)
			->withBulan($bulan);

	}

	public function tanggal()
	{

		// return Input::all();
		$tanggal     = Yoga::blnPrep(Input::get('bulanTahun'));
		$asuransi_id = Input::get('asuransi_id');
		$asuransi    = Asuransi::find($asuransi_id);

		if ($asuransi_id != '%') {
			$nama_asuransi = $asuransi->nama;
		} else {
			$nama_asuransi = 'Semua Pembayaran';
		}
		$query = "SELECT p. tanggal, min(s.nama), count(p.id) as jumlah, sum(p.tunai) as tunai, sum(p.piutang) as piutang FROM periksas as p left outer join asuransis as s on s.id = p.asuransi_id where p.tanggal like '{$tanggal}%' AND asuransi_id like '{$asuransi_id}' group by p.tanggal";
		$tanggal = DB::select($query);
		$bln = Input::get('bulanTahun');


		$date = Yoga::blnPrep(Input::get('bulanTahun'));
 
		$query = "SELECT p.asuransi_id as asuransi_id, p.tanggal as tanggal, asu.nama as asuransi, count(*) as jumlah, sum(p.tunai) as tunai, sum(p.piutang) as piutang from periksas as p join asuransis as asu on asu.id = p.asuransi_id where p.tanggal like '{$date}%' group by p.tanggal, p.asuransi_id";

		$daftar_asuransi = DB::select($query);
		$rows = [];
		$tanggals = $this->unique($daftar_asuransi, 'tanggal');
		$asuransis = $this->unique($daftar_asuransi, 'asuransi');
		foreach ($tanggals as $k=> $tg) {
			$rows[$k]['tanggal'] = $tg;
		}
		foreach ($rows as $k => $row) {
			foreach ($daftar_asuransi as $d) {
				if ($d->tanggal == $row['tanggal']) {
					foreach ($asuransis as $asu) {
						if ($d->asuransi == $asu) {
							$rows[$k][$d->asuransi] = $d->jumlah;
						}else {
							$rows[$k][$asu] = '0';
						}
					}
				}
			}
		}

		$totalTanggal = 0;
		$totalTunaiTanggal = 0;
		$totalPiutangTanggal = 0;
		$totalJumlahTanggal = 0;
		foreach ($tanggal as $k => $v) {
			# code...
			$totalTunaiTanggal += $v->tunai;
			$totalPiutangTanggal += $v->piutang;
			$totalJumlahTanggal += $v->jumlah;
			$totalTanggal += $v->tunai + $v->piutang;
		}

		return view('laporans.tanggal', compact(
			'tanggal', 
			'totalTunaiTanggal', 
			'totalTanggal', 
			'totalPiutangTanggal', 
			'daftar_asuransi', 
			'totalJumlahTanggal', 
			'bln', 
			'rows', 
			'nama_asuransi'));

	}

	public function detbulan()
	{

		$tanggal 		= Yoga::blnPrep(Input::get('bulanTahun'));
		$asuransi_id 	= Input::get('asuransi_id');


		$query = "SELECT icd.diagnosaICD as diagnosaICD, p.tanggal, ps.nama, s.nama as nama_asuransi, p.tunai as tunai, p.piutang as piutang, p.transaksi as transaksi, sum(tr.harga_beli_satuan * tr.jumlah) as modal_obat, p.id as periksa_id, p.created_at as created_at FROM terapis as tr join periksas as p on p.id = tr.periksa_id left outer join asuransis as s on s.id = p.asuransi_id left outer join pasiens as ps on ps.id = p.pasien_id join diagnosas as dg on dg.id = p.diagnosa_id join icd10s as icd on icd.id = dg.icd10_id where p.tanggal like '{$tanggal}%' AND p.asuransi_id like '{$asuransi_id}' group by p.id order by p.id desc";
		// $query = "SELECT ";

		if ($asuransi_id == '%') {
			$nama_asuransi = 'Semua Pembayaran';
		} else {
			$nama_asuransi = Asuransi::find($asuransi_id)->nama;
		}
		$tanggall = $tanggal;
		$tanggal = DB::select($query);

		$modal = 0;

		$rincian = Yoga::rincian($tanggal);

		return view('laporans.detbulan')
			->withTanggall($tanggall)
			->withTanggal($tanggal)
			->with('asuransi_id', $asuransi_id)
			->with('nama_asuransi', $nama_asuransi)
			->withRincian($rincian);

	}
	public function payment($id)
	{
		$asuransi_controller = new AsuransisController;
		$hutang_asuransis    = $asuransi_controller->hutangs_template(0,$id);
		$asuransi            = Asuransi::find($id);
		return view('laporans.payment', compact('hutang_asuransis','asuransi'));

	}
	public function paymentpost()
	{
		$biaya = Input::get('biaya');
		$temp = Input::get('temp');
		$array = json_decode($temp, true);
		$id = Input::get('asuransi_id');

		$asuransi = Asuransi::find($id);

		if ($biaya > 0) {
            $nota_jual_id = Yoga::customId('App\Models\NotaJual');
			$pn = new NotaJual;
			$pn->id = $nota_jual_id;
			$pn->tanggal = Yoga::datePrep( Input::get('tanggal') );
			$confirm = $pn->save();

            if ($confirm) {
                foreach ($array as $key => $arr) {
                    if ($arr['piutang_dibayar'] > $arr['piutang_dibayar_awal']) {
                        $px = new PembayaranAsuransi;
                        $px->periksa_id = $arr['id'];
                        $px->nota_jual_id = $nota_jual_id;
                        $px->pembayaran =(int)$arr['piutang_dibayar'] - (int)$arr['piutang_dibayar_awal'];
                        $px->save();
                    }
                }

				$jurnal                  = new JurnalUmum;
				$jurnal->jurnalable_id   = $nota_jual_id;
				$jurnal->jurnalable_type = 'App\Models\NotaJual';
				$jurnal->coa_id          = 110000; // Kas di tangan
				$jurnal->debit           = 1;
				$jurnal->nilai           = $biaya;
				$jurnal->save();


				$jurnal                  = new JurnalUmum;
				$jurnal->jurnalable_id   = $nota_jual_id;
				$jurnal->jurnalable_type = 'App\Models\NotaJual';
				$jurnal->coa_id          = $asuransi->coa_id;
				$jurnal->debit           = 0;
				$jurnal->nilai           = $biaya;
				$jurnal->save();
            }
		}

		return redirect('asuransis')->withPesan(Yoga::suksesFlash('Telah dilakukan pembayaran untuk <strong>Asuransi ' .$id. ' - ' . $asuransi->nama. '</strong> sebesar <strong class="uang">' . $biaya . '</strong>'));

	}
	public function penyakit()
	{
		$asuransi_id 	= Input::get('asuransi_id');
		$mulai 	= Yoga::datePrep( Input::get('mulai') );
		$akhir 	= Yoga::datePrep( Input::get('akhir') );

		$query = "SELECT i.id, i.diagnosaICD, count(p.id) as jumlah FROM periksas as p left outer join asuransis as s on s.id = p.asuransi_id left outer join pasiens as ps on ps.id = p.pasien_id left outer join diagnosas as dg on dg.id = p.diagnosa_id left outer join icd10s as i on i.id = dg.icd10_id where p.tanggal >= '{$mulai}' AND p.tanggal <= '{$akhir}' AND p.asuransi_id like '{$asuransi_id}' group by i.id order by jumlah desc";
		$tanggal = DB::select($query);

		return view('laporans.penyakit')
			->withTanggal($tanggal)
			->withMulai($mulai)
			->withAkhir($akhir);
	}

	public function status()
	{

		$mulai = Yoga::datePrep(Input::get('mulai'));
		$akhir = Yoga::datePrep(Input::get('akhir'));
		$staf_id = Input::get('staf_id');

		$periksas = Periksa::whereRaw("date(tanggal) between '$mulai' and '$akhir'")
			->where('staf_id', $staf_id)
			->with(
				'terapii.merek',
			   	'transaksii.jenisTarif',
				'jurnals.coa',
				'asuransi',
				'staf',
				'pasien',
				'diagnosa.icd10'
			)
			->paginate(4);
		return view('laporans.status', compact('periksas'));

	}
	public function points()
	{

		$mulai = Input::get('mulai');
		$akhir = Input::get('akhir');

		$mulai = Yoga::nowIfEmptyMulai($mulai);
		$akhir = Yoga::nowIfEmptyAkhir($akhir);

		$query  = "SELECT st.nama, ";
		$query .= "count(pn.tekanan_darah) as tekanan_darah, ";
		$query .= "count(pn.suhu) as suhu, ";
		$query .= "count(pn.berat_badan) as berat_badan, ";
		$query .= "count(pn.tinggi_badan) as tinggi_badan ";
		$query .= "FROM points as pn ";
		$query .= "join periksas as px on px.id = pn.periksa_id ";
		$query .= "join stafs as st on st.id = px.asisten_id ";
		$query .= "where pn.created_at between '{$mulai}' and '{$akhir}' ";
		$query .= "group by nama";


		$points = DB::select($query);

		return view('laporans.poin', compact('points'));

	}
	public function pendapatan()
	{
		// return Input::all();
		$mulai = Input::get('mulai');
		$akhir = Input::get('akhir');

		$mulai = Yoga::nowIfEmptyMulai($mulai);
		$akhir = Yoga::nowIfEmptyAkhir($akhir);

		$pendapatans = Pendapatan::whereRaw("created_at between '{$mulai}' and '{$akhir}'")->get();
		// return $pendapatans;
		// return $pendapatan->last()->created_at;
		// $query = "SELECT max(st.nama) as nama, count(px.suhu) as suhu, count(tinggi_badan) as tb, count(berat_badan) as bb, count(tekanan_darah) as tensi FROM points as px left outer join stafs as st on st.id = px.staf_id WHERE px.tanggal BETWEEN '{$mulai} 00:00:00' and '{$akhir} 23:59:59' group by nama;";

		// return var_dump($points);

		return view('laporans.pendapatan', compact('pendapatans', 'mulai', 'akhir'));



	}

	public function rujukankebidanan(){
		// return 'oke';
		$mulai = Input::get('mulai');
		$akhir = Input::get('akhir');

		$mulai = Yoga::nowIfEmptyMulai($mulai);
		$akhir = Yoga::nowIfEmptyAkhir($akhir);

		$query = "SELECT ps.nama as nama_pasien, icd.id as icd10_id, ps.tanggal_lahir as tanggal_lahir, icd.diagnosaICD as diagnosa, tj.tujuan_rujuk as tujuan_rujuk, px.tanggal as tanggal, rj.complication as complication  from rujukans as rj join periksas as px on px.id = rj.periksa_id join diagnosas as dg on dg.id=px.diagnosa_id join icd10s as icd on icd.id=dg.icd10_id join tujuan_rujuks as tj on tj.id=rj.tujuan_rujuk_id join pasiens as ps on ps.id=px.pasien_id where rj.tujuan_rujuk_id = '24' and tanggal between '{$mulai}' and '{$akhir}'";
		$rujukans = DB::select($query);

		return view('laporans.rujukankebidanan', compact('rujukans'));
	}
    public function bayardokter(){
		// return 'oke';
		$id = Input::get('id');
		$staf = Staf::find($id);
		if (is_null($staf)) {
			$pesan = Yoga::gagalFlash('Nama Dokter tidak ditemukan');
			return redirect()->back()->withPesan($pesan);
		}
        $nama_staf = $staf->nama;

		$mulai = Input::get('mulai');
		$akhir = Input::get('akhir');

		$mulai = Yoga::nowIfEmptyMulai($mulai);
		$akhir = Yoga::nowIfEmptyAkhir($akhir);
         
        $query = "select p.tanggal as tanggal, st.nama as nama_staf, ps.id as pasien_id, ps.nama as nama, asu.nama as nama_asuransi, tunai, piutang, nilai  from jurnal_umums as ju join periksas as p on p.id=ju.jurnalable_id join stafs as st on st.id= p.staf_id join pasiens as ps on ps.id=p.pasien_id join asuransis as asu on asu.id=p.asuransi_id where jurnalable_type='App\\\Models\\\Periksa' and p.staf_id='{$id}' and ju.coa_id=200001 and ( p.tanggal between '{$mulai}' and '{$akhir}' );";
        $hutangs = DB::select($query);
        $total = 0;
        foreach ($hutangs as $hutang) {
            $total += $hutang->nilai;
        }
        return view('gajidokter', compact('hutangs', 'total', 'nama_staf', 'mulai', 'akhir'));
    }
    public function pembayarandokter(){
		$mulai = Input::get('mulai');
		$akhir = Input::get('akhir');
		$mulai = Yoga::nowIfEmptyMulai($mulai);
		$akhir = Yoga::nowIfEmptyAkhir($akhir);
         
        $bayardokters = BayarDokter::whereRaw("created_at between '{$mulai}' and '{$akhir}'")->get();
        return view('bayar_dokters.index', compact('bayardokters'));
         
    }
    public function no_asisten(){
		$tanggal 		= Yoga::blnPrep(Input::get('bulanTahun'));
        $periksas = Periksa::where('tanggal', 'like', $tanggal . '%')->where('periksa_awal', '[]')->get();
        //return $periksas;
        return view('laporans.no_asisten', compact('periksas'));
    }
    public function gigiBulanan(){
		$tanggal 		= Yoga::blnPrep(Input::get('bulanTahun'));
        $periksas = Periksa::where('tanggal', 'like', $tanggal . '%')->where('poli', 'gigi')->get();
        //return $periksas;
        return view('laporans.gigi', compact('periksas'));
    }
    public function anc(){
		$tanggal 		= Yoga::blnPrep(Input::get('bulanTahun'));
		$query = "select px.tanggal as tanggal, ";
		$query .= "st.nama as nama_staf,";
		$query .= " px.jam as jam,";
		$query .= " ps.nama as nama_pasien,";
		$query .= " px.poli as poli,";
		$query .= " px.pemeriksaan_fisik as pf";
		$query .= " from periksas as px";
		$query .= " join stafs as st on st.id=px.staf_id";
		$query .= " join pasiens as ps on ps.id=px.pasien_id";
		$query .= " join diagnosas as dg on dg.id = px.diagnosa_id";
		$query .= " where st.titel = 'bd'";
		$query .= " and tanggal like '{$tanggal}%'";
		$query .= " and (px.poli = 'anc');";
        $periksas = DB::select($query);
        $query = "select min( st.nama ) as nama_staf, count(*) as jumlah from periksas as px join stafs as st on st.id=px.staf_id join pasiens as ps on ps.id=px.pasien_id join diagnosas as dg on dg.id = px.diagnosa_id where st.titel = 'bd' and tanggal like '{$tanggal}%' and (px.poli = 'anc') group by staf_id;";
        $group_by_stafs = DB::select($query);
        //return $periksas;
        return view('laporans.anc', compact('periksas', 'group_by_stafs'));
    }
    public function kb(){
		$tanggal 		= Yoga::blnPrep(Input::get('bulanTahun'));
		$query = "select px.tanggal as tanggal, ";
		$query .= "st.nama as nama_staf,";
		$query .= " px.jam as jam,";
		$query .= " asu.nama as nama_asuransi,";
		$query .= " ps.nama as nama_pasien,";
		$query .= " px.poli as poli,";
		$query .= " px.pemeriksaan_fisik as pf";
		$query .= " from periksas as px";
		$query .= " join stafs as st on st.id=px.staf_id";
		$query .= " join asuransis as asu on asu.id=px.asuransi_id";
		$query .= " join pasiens as ps on ps.id=px.pasien_id";
		$query .= " where st.titel = 'bd' and tanggal like '{$tanggal}%'";
		$query .= " and diagnosa_id in (19,941);";
        $periksas_diagnosa_kb = DB::select($query);
        $query = "select min( st.nama ) as nama_staf, count(*) as jumlah from periksas as px join stafs as st on st.id=px.staf_id join pasiens as ps on ps.id=px.pasien_id where st.titel = 'bd' and tanggal like '{$tanggal}%' and diagnosa_id in (19,941) group by staf_id;";
        $group_by_stafs = DB::select($query);
        
        //return $periksas;
        return view('laporans.kb', compact('periksas_diagnosa_kb', 'group_by_stafs'));
    }
    public function jumlahPasien(){
        //$periksas = Periksa::where('asuransi_id', 'like', $asuransi_id )
                            //->where('created_at', '>=', $mulai)
                            //->where('created_at', '<=', $akhir)
                            //->get();
        
        $asuransi_id = Input::get('asuransi_id');
        $akhir = Yoga::datePrep( Input::get('akhir') );
        $mulai = Yoga::datePrep( Input::get('mulai') );
        $query = "SELECT asu.nama as nama_asuransi, count(*) jumlah FROM periksas as px join asuransis as asu on asu.id=px.asuransi_id where asuransi_id like '{$asuransi_id}' and px.created_at >= '{$mulai} 00:00:00' and px.created_at <= '{$akhir} 00:00:00' GROUP BY px.asuransi_id order by jumlah desc;";
        $jumlah = DB::select($query);
        $total = 0;
        foreach ($jumlah as $hml) {
            $total += $hml->jumlah;
        }
        return view('laporans.jumlah', compact('jumlah', 'mulai', 'akhir', 'total'));

    }
    public function jumlahIspa(){
        $asuransi_id = Input::get('asuransi_id');
        $akhir = Yoga::datePrep( Input::get('akhir') );
        $mulai = Yoga::datePrep( Input::get('mulai') );
        $query = "select count(*) as jumlah from periksas as px join diagnosas as dg on dg.id = px.diagnosa_id join pasiens as ps on ps.id = px.pasien_id where date(px.tanggal) between '{$mulai}' and '{$akhir}' and dg.icd10_id = 'J06' and TIMESTAMPDIFF(YEAR, ps.tanggal_lahir, px.tanggal) = 0 and ps.sex = 1;";
        $jumlahIspa_0_1_L = DB::select($query)[0]->jumlah;
        $query = "select count(*) as jumlah from periksas as px join diagnosas as dg on dg.id = px.diagnosa_id join pasiens as ps on ps.id = px.pasien_id where date(px.tanggal) between '{$mulai}' and '{$akhir}' and dg.icd10_id = 'J06' and TIMESTAMPDIFF(YEAR, ps.tanggal_lahir, px.tanggal) between 1 and 5 and ps.sex = 1;";
        $jumlahIspa_1_5_L = DB::select($query)[0]->jumlah;
        $query = "select count(*) as jumlah from periksas as px join diagnosas as dg on dg.id = px.diagnosa_id join pasiens as ps on ps.id = px.pasien_id where date(px.tanggal) between '{$mulai}' and '{$akhir}' and dg.diagnosa like '%pneum%' and TIMESTAMPDIFF(YEAR, ps.tanggal_lahir, px.tanggal) = 0 and ps.sex = 1;";
        $jumlahPneumonia_0_1_L = DB::select($query)[0]->jumlah;
        $query = "select count(*) as jumlah from periksas as px join diagnosas as dg on dg.id = px.diagnosa_id join pasiens as ps on ps.id = px.pasien_id where date(px.tanggal) between '{$mulai}' and '{$akhir}' and dg.diagnosa like '%pneum%' and TIMESTAMPDIFF(YEAR, ps.tanggal_lahir, px.tanggal) between 1 and 5 and ps.sex = 1;";
        $jumlahPneumonia_1_5_L = DB::select($query)[0]->jumlah;
        $query = "select count(*) as jumlah from periksas as px join diagnosas as dg on dg.id = px.diagnosa_id join pasiens as ps on ps.id = px.pasien_id where date(px.tanggal) between '{$mulai}' and '{$akhir}' and (dg.icd10_id like 'a00%' or dg.icd10_id like 'a04%' or dg.icd10_id like 'a06%' or dg.icd10_id like 'a08%' or dg.icd10_id like 'a09%') and TIMESTAMPDIFF(YEAR, ps.tanggal_lahir, px.tanggal) = 0 and ps.sex = 1;";
        $jumlahDiare_0_1_L = DB::select($query)[0]->jumlah;
        $query = "select count(*) as jumlah from periksas as px join diagnosas as dg on dg.id = px.diagnosa_id join pasiens as ps on ps.id = px.pasien_id where date(px.tanggal) between '{$mulai}' and '{$akhir}' and (dg.icd10_id like 'a00%' or dg.icd10_id like 'a04%' or dg.icd10_id like 'a06%' or dg.icd10_id like 'a08%' or dg.icd10_id like 'a09%') and TIMESTAMPDIFF(YEAR, ps.tanggal_lahir, px.tanggal) between 1 and 5 and ps.sex = 1;";
        $jumlahDiare_1_5_L = DB::select($query)[0]->jumlah;
        $query = "select count(*) as jumlah from periksas as px join diagnosas as dg on dg.id = px.diagnosa_id join pasiens as ps on ps.id = px.pasien_id where date(px.tanggal) between '{$mulai}' and '{$akhir}' and dg.icd10_id = 'J06' and TIMESTAMPDIFF(YEAR, ps.tanggal_lahir, px.tanggal) > 5 and ps.sex = 1;";
        $jumlahIspaBukanPneumonia_diatas_5_tahun_L = DB::select($query)[0]->jumlah;
        $query = "select count(*) as jumlah from periksas as px join diagnosas as dg on dg.id = px.diagnosa_id join pasiens as ps on ps.id = px.pasien_id where date(px.tanggal) between '{$mulai}' and '{$akhir}' and dg.diagnosa like '%pneum%' and TIMESTAMPDIFF(YEAR, ps.tanggal_lahir, px.tanggal) > 5 and ps.sex = 1;";
        $jumlahIspaPneumonia_diatas_5_tahun_L = DB::select($query)[0]->jumlah;

        //$data = 'jumlahIspa_0_1 = ' . $jumlahIspa_0_1 . '<br />';
        //$data .= 'jumlahIspa_1_5 = ' . $jumlahIspa_1_5 . '<br />';
        //$data .= 'jumlahPneumonia_1_5 = ' . $jumlahPneumonia_1_5 . '<br />';
        //$data .= 'jumlahPneumonia_0_1 = ' . $jumlahPneumonia_0_1 . '<br />';
        //$data .= 'jumlahDiare_0_1 = ' . $jumlahDiare_0_1 . '<br />';
        //$data .= 'jumlahDiare_1_5 = ' . $jumlahDiare_1_5 . '<br />';
        //$data .= 'jumlahIspaPneumonia_diatas_5_tahun = ' . $jumlahIspaPneumonia_diatas_5_tahun . '<br />';
        //$data .= 'jumlahIspaBukanPneumonia_diatas_5_tahun = ' . $jumlahIspaBukanPneumonia_diatas_5_tahun . '<br />';
        //return $data;
        $query = "select count(*) as jumlah from periksas as px join diagnosas as dg on dg.id = px.diagnosa_id join pasiens as ps on ps.id = px.pasien_id where date(px.tanggal) between '{$mulai}' and '{$akhir}' and dg.icd10_id = 'J06' and TIMESTAMPDIFF(YEAR, ps.tanggal_lahir, px.tanggal) = 0 and ps.sex = 0;";
        $jumlahIspa_0_1_P = DB::select($query)[0]->jumlah;
        $query = "select count(*) as jumlah from periksas as px join diagnosas as dg on dg.id = px.diagnosa_id join pasiens as ps on ps.id = px.pasien_id where date(px.tanggal) between '{$mulai}' and '{$akhir}' and dg.icd10_id = 'J06' and TIMESTAMPDIFF(YEAR, ps.tanggal_lahir, px.tanggal) between 1 and 5 and ps.sex = 0;";
        $jumlahIspa_1_5_P = DB::select($query)[0]->jumlah;
        $query = "select count(*) as jumlah from periksas as px join diagnosas as dg on dg.id = px.diagnosa_id join pasiens as ps on ps.id = px.pasien_id where date(px.tanggal) between '{$mulai}' and '{$akhir}' and dg.diagnosa like '%pneum%' and TIMESTAMPDIFF(YEAR, ps.tanggal_lahir, px.tanggal) = 0 and ps.sex = 0;";
        $jumlahPneumonia_0_1_P = DB::select($query)[0]->jumlah;
        $query = "select count(*) as jumlah from periksas as px join diagnosas as dg on dg.id = px.diagnosa_id join pasiens as ps on ps.id = px.pasien_id where date(px.tanggal) between '{$mulai}' and '{$akhir}' and dg.diagnosa like '%pneum%' and TIMESTAMPDIFF(YEAR, ps.tanggal_lahir, px.tanggal) between 1 and 5 and ps.sex = 0;";
        $jumlahPneumonia_1_5_P = DB::select($query)[0]->jumlah;
        $query = "select count(*) as jumlah from periksas as px join diagnosas as dg on dg.id = px.diagnosa_id join pasiens as ps on ps.id = px.pasien_id where date(px.tanggal) between '{$mulai}' and '{$akhir}' and (dg.icd10_id like 'a00%' or dg.icd10_id like 'a04%' or dg.icd10_id like 'a06%' or dg.icd10_id like 'a08%' or dg.icd10_id like 'a09%') and TIMESTAMPDIFF(YEAR, ps.tanggal_lahir, px.tanggal) = 0 and ps.sex = 0;";
        $jumlahDiare_0_1_P = DB::select($query)[0]->jumlah;
        $query = "select count(*) as jumlah from periksas as px join diagnosas as dg on dg.id = px.diagnosa_id join pasiens as ps on ps.id = px.pasien_id where date(px.tanggal) between '{$mulai}' and '{$akhir}' and (dg.icd10_id like 'a00%' or dg.icd10_id like 'a04%' or dg.icd10_id like 'a06%' or dg.icd10_id like 'a08%' or dg.icd10_id like 'a09%') and TIMESTAMPDIFF(YEAR, ps.tanggal_lahir, px.tanggal) between 1 and 5 and ps.sex = 0;";
        $jumlahDiare_1_5_P = DB::select($query)[0]->jumlah;
        $query = "select count(*) as jumlah from periksas as px join diagnosas as dg on dg.id = px.diagnosa_id join pasiens as ps on ps.id = px.pasien_id where date(px.tanggal) between '{$mulai}' and '{$akhir}' and dg.icd10_id = 'J06' and TIMESTAMPDIFF(YEAR, ps.tanggal_lahir, px.tanggal) > 5 and ps.sex = 0;";
        $jumlahIspaBukanPneumonia_diatas_5_tahun_P = DB::select($query)[0]->jumlah;
        $query = "select count(*) as jumlah from periksas as px join diagnosas as dg on dg.id = px.diagnosa_id join pasiens as ps on ps.id = px.pasien_id where date(px.tanggal) between '{$mulai}' and '{$akhir}' and dg.diagnosa like '%pneum%' and TIMESTAMPDIFF(YEAR, ps.tanggal_lahir, px.tanggal) > 5 and ps.sex = 0;";
        $jumlahIspaPneumonia_diatas_5_tahun_P = DB::select($query)[0]->jumlah;

        $data = 
            [
            [
                'keterangan' => 'Jumlah ISPA 0 - 1 t_Lahun Laki-laki',
                'jumlah' => $jumlahIspa_0_1_L
            ],
            [
                'keterangan' => 'Jumlah ISPA 1 - 5 tahun Laki-laki',
                'jumlah' => $jumlahIspa_1_5_L
            ],
            [
                'keterangan' => 'Jumlah Pneumonia 0 - 1  tahun Laki-laki',
                'jumlah' => $jumlahPneumonia_0_1_L
            ],
            [
                'keterangan' => 'Jumlah Pneumonia 1 - 5  tahun Laki-laki',
                'jumlah' => $jumlahPneumonia_1_5_L
            ],
            [
                'keterangan' => 'Jumlah Ispa Dengan Pneumonia diatas 5 tahun Laki-laki',
                'jumlah' => $jumlahIspaPneumonia_diatas_5_tahun_L
            ],
            [
                'keterangan' => 'Jumlah Ispa Bukan Pneumonia diatas 5 tahun Laki-laki',
                'jumlah' => $jumlahIspaBukanPneumonia_diatas_5_tahun_L
            ],
            [
                'keterangan' => 'Jumlah ISPA 0 - 1 tahun Perempuan',
                'jumlah' => $jumlahIspa_0_1_P
            ],
            [
                'keterangan' => 'Jumlah ISPA 1 - 5 tahun Perempuan',
                'jumlah' => $jumlahIspa_1_5_P
            ],
            [
                'keterangan' => 'Jumlah Pneumonia 0 - 1  tahun Perempuan',
                'jumlah' => $jumlahPneumonia_0_1_P
            ],
            [
                'keterangan' => 'Jumlah Pneumonia 1 - 5  tahun Perempuan',
                'jumlah' => $jumlahPneumonia_1_5_P
            ],
            [
                'keterangan' => 'Jumlah Ispa Dengan Pneumonia diatas 5 tahun Perempuan',
                'jumlah' => $jumlahIspaPneumonia_diatas_5_tahun_P
            ],
            [
                'keterangan' => 'Jumlah Ispa Bukan Pneumonia diatas 5 tahun Perempuan',
                'jumlah' => $jumlahIspaBukanPneumonia_diatas_5_tahun_P
            ],
        ];
        

        return view('laporans.jumlahIspa', compact('data', 'mulai', 'akhir'));
         
    }

    public function JumlahDiare(){
        $asuransi_id = Input::get('asuransi_id');
        $akhir = Yoga::datePrep( Input::get('akhir') );
        $mulai = Yoga::datePrep( Input::get('mulai') );
        $query = "select count(*) as jumlah from periksas as px join diagnosas as dg on dg.id = px.diagnosa_id join pasiens as ps on ps.id = px.pasien_id where date(px.tanggal) between '{$mulai}' and '{$akhir}' and (dg.icd10_id like 'a00%' or dg.icd10_id like 'a04%' or dg.icd10_id like 'a06%' or dg.icd10_id like 'a08%' or dg.icd10_id like 'a09%') and TIMESTAMPDIFF(MONTH, ps.tanggal_lahir, px.tanggal) between 0 and 5 and ps.sex = 1;";
        $jumlahDiare_0_5_L = DB::select($query)[0]->jumlah;

        $query = "select count(*) as jumlah from periksas as px join diagnosas as dg on dg.id = px.diagnosa_id join pasiens as ps on ps.id = px.pasien_id where date(px.tanggal) between '{$mulai}' and '{$akhir}' and (dg.icd10_id like 'a00%' or dg.icd10_id like 'a04%' or dg.icd10_id like 'a06%' or dg.icd10_id like 'a08%' or dg.icd10_id like 'a09%') and TIMESTAMPDIFF(MONTH, ps.tanggal_lahir, px.tanggal) between 0 and 5 and ps.sex = 0;";
        $jumlahDiare_0_5_P = DB::select($query)[0]->jumlah;

        $query = "select count(*) as jumlah from periksas as px join diagnosas as dg on dg.id = px.diagnosa_id join pasiens as ps on ps.id = px.pasien_id where date(px.tanggal) between '{$mulai}' and '{$akhir}' and (dg.icd10_id like 'a00%' or dg.icd10_id like 'a04%' or dg.icd10_id like 'a06%' or dg.icd10_id like 'a08%' or dg.icd10_id like 'a09%') and TIMESTAMPDIFF(MONTH, ps.tanggal_lahir, px.tanggal) between 6 and 11 and ps.sex = 1;";
        $jumlahDiare_6_12_L = DB::select($query)[0]->jumlah;

        $query = "select count(*) as jumlah from periksas as px join diagnosas as dg on dg.id = px.diagnosa_id join pasiens as ps on ps.id = px.pasien_id where date(px.tanggal) between '{$mulai}' and '{$akhir}' and (dg.icd10_id like 'a00%' or dg.icd10_id like 'a04%' or dg.icd10_id like 'a06%' or dg.icd10_id like 'a08%' or dg.icd10_id like 'a09%') and TIMESTAMPDIFF(MONTH, ps.tanggal_lahir, px.tanggal) between 6 and 11 and ps.sex = 0;";
        $jumlahDiare_6_12_P = DB::select($query)[0]->jumlah;
         
        $query = "select count(*) as jumlah from periksas as px join diagnosas as dg on dg.id = px.diagnosa_id join pasiens as ps on ps.id = px.pasien_id where date(px.tanggal) between '{$mulai}' and '{$akhir}' and (dg.icd10_id like 'a00%' or dg.icd10_id like 'a04%' or dg.icd10_id like 'a06%' or dg.icd10_id like 'a08%' or dg.icd10_id like 'a09%') and TIMESTAMPDIFF(YEAR, ps.tanggal_lahir, px.tanggal) between 1 and 4 and ps.sex = 1;";
        $jumlahDiare_1_4_L = DB::select($query)[0]->jumlah;

        $query = "select count(*) as jumlah from periksas as px join diagnosas as dg on dg.id = px.diagnosa_id join pasiens as ps on ps.id = px.pasien_id where date(px.tanggal) between '{$mulai}' and '{$akhir}' and (dg.icd10_id like 'a00%' or dg.icd10_id like 'a04%' or dg.icd10_id like 'a06%' or dg.icd10_id like 'a08%' or dg.icd10_id like 'a09%') and TIMESTAMPDIFF(YEAR, ps.tanggal_lahir, px.tanggal) between 1 and 4 and ps.sex = 0;";
        $jumlahDiare_1_4_P = DB::select($query)[0]->jumlah;
         
        $query = "select count(*) as jumlah from periksas as px join diagnosas as dg on dg.id = px.diagnosa_id join pasiens as ps on ps.id = px.pasien_id where date(px.tanggal) between '{$mulai}' and '{$akhir}' and (dg.icd10_id like 'a00%' or dg.icd10_id like 'a04%' or dg.icd10_id like 'a06%' or dg.icd10_id like 'a08%' or dg.icd10_id like 'a09%') and TIMESTAMPDIFF(YEAR, ps.tanggal_lahir, px.tanggal) between 5 and 9 and ps.sex = 1;";
        $jumlahDiare_5_9_L = DB::select($query)[0]->jumlah;
         
        $query = "select count(*) as jumlah from periksas as px join diagnosas as dg on dg.id = px.diagnosa_id join pasiens as ps on ps.id = px.pasien_id where date(px.tanggal) between '{$mulai}' and '{$akhir}' and (dg.icd10_id like 'a00%' or dg.icd10_id like 'a04%' or dg.icd10_id like 'a06%' or dg.icd10_id like 'a08%' or dg.icd10_id like 'a09%') and TIMESTAMPDIFF(YEAR, ps.tanggal_lahir, px.tanggal) between 5 and 9 and ps.sex = 0;";
        $jumlahDiare_5_9_P = DB::select($query)[0]->jumlah;

        $query = "select count(*) as jumlah from periksas as px join diagnosas as dg on dg.id = px.diagnosa_id join pasiens as ps on ps.id = px.pasien_id where date(px.tanggal) between '{$mulai}' and '{$akhir}' and (dg.icd10_id like 'a00%' or dg.icd10_id like 'a04%' or dg.icd10_id like 'a06%' or dg.icd10_id like 'a08%' or dg.icd10_id like 'a09%') and TIMESTAMPDIFF(YEAR, ps.tanggal_lahir, px.tanggal) between 10 and 14 and ps.sex = 1;";
        $jumlahDiare_10_14_L = DB::select($query)[0]->jumlah;

        $query = "select count(*) as jumlah from periksas as px join diagnosas as dg on dg.id = px.diagnosa_id join pasiens as ps on ps.id = px.pasien_id where date(px.tanggal) between '{$mulai}' and '{$akhir}' and (dg.icd10_id like 'a00%' or dg.icd10_id like 'a04%' or dg.icd10_id like 'a06%' or dg.icd10_id like 'a08%' or dg.icd10_id like 'a09%') and TIMESTAMPDIFF(YEAR, ps.tanggal_lahir, px.tanggal) between 10 and 14 and ps.sex = 0;";
        $jumlahDiare_10_14_P = DB::select($query)[0]->jumlah;
         
        $query = "select count(*) as jumlah from periksas as px join diagnosas as dg on dg.id = px.diagnosa_id join pasiens as ps on ps.id = px.pasien_id where date(px.tanggal) between '{$mulai}' and '{$akhir}' and (dg.icd10_id like 'a00%' or dg.icd10_id like 'a04%' or dg.icd10_id like 'a06%' or dg.icd10_id like 'a08%' or dg.icd10_id like 'a09%') and TIMESTAMPDIFF(YEAR, ps.tanggal_lahir, px.tanggal) between 15 and 19 and ps.sex = 1;";
        $jumlahDiare_15_19_L = DB::select($query)[0]->jumlah;

        $query = "select count(*) as jumlah from periksas as px join diagnosas as dg on dg.id = px.diagnosa_id join pasiens as ps on ps.id = px.pasien_id where date(px.tanggal) between '{$mulai}' and '{$akhir}' and (dg.icd10_id like 'a00%' or dg.icd10_id like 'a04%' or dg.icd10_id like 'a06%' or dg.icd10_id like 'a08%' or dg.icd10_id like 'a09%') and TIMESTAMPDIFF(YEAR, ps.tanggal_lahir, px.tanggal) between 15 and 19 and ps.sex = 0;";
        $jumlahDiare_15_19_P = DB::select($query)[0]->jumlah;
        $query = "select count(*) as jumlah from periksas as px join diagnosas as dg on dg.id = px.diagnosa_id join pasiens as ps on ps.id = px.pasien_id where date(px.tanggal) between '{$mulai}' and '{$akhir}' and (dg.icd10_id like 'a00%' or dg.icd10_id like 'a04%' or dg.icd10_id like 'a06%' or dg.icd10_id like 'a08%' or dg.icd10_id like 'a09%') and TIMESTAMPDIFF(YEAR, ps.tanggal_lahir, px.tanggal) > 20 and ps.sex = 1;";
        $jumlahDiare_20_L = DB::select($query)[0]->jumlah;

        $query = "select count(*) as jumlah from periksas as px join diagnosas as dg on dg.id = px.diagnosa_id join pasiens as ps on ps.id = px.pasien_id where date(px.tanggal) between '{$mulai}' and '{$akhir}' and (dg.icd10_id like 'a00%' or dg.icd10_id like 'a04%' or dg.icd10_id like 'a06%' or dg.icd10_id like 'a08%' or dg.icd10_id like 'a09%') and TIMESTAMPDIFF(YEAR, ps.tanggal_lahir, px.tanggal) > 20 and ps.sex = 0;";
        $jumlahDiare_20_P = DB::select($query)[0]->jumlah;

        $query = "select count(*) as jumlah from periksas as px join diagnosas as dg on dg.id = px.diagnosa_id join pasiens as ps on ps.id = px.pasien_id where date(px.tanggal) between '{$mulai}' and '{$akhir}' and (dg.icd10_id like 'a00%' or dg.icd10_id like 'a04%' or dg.icd10_id like 'a06%' or dg.icd10_id like 'a08%' or dg.icd10_id like 'a09%');";
        $jumlahDiare = DB::select($query)[0]->jumlah;

        $query = "select count(*) as jumlah from terapis as tp join periksas as px on px.id = tp.periksa_id join mereks as mr on mr.id = tp.merek_id join raks as rk on rk.id = mr.rak_id join formulas as fr on fr.id=rk.formula_id where fr.id='150811020' and date(px.tanggal) between '{$mulai}' and '{$akhir}';";
        $jumlahOralit = DB::select($query)[0]->jumlah;


        $query = "select count(*) as jumlah from terapis as tp join periksas as px on px.id = tp.periksa_id join mereks as mr on mr.id = tp.merek_id join raks as rk on rk.id = mr.rak_id join formulas as fr on fr.id=rk.formula_id join pasiens as ps on ps.id = px.pasien_id where fr.id='150802006' and date(px.tanggal) between '{$mulai}' and '{$akhir}' and TIMESTAMPDIFF(MONTH, ps.tanggal_lahir, px.tanggal) between 0 and 5;";
        $jumlahZink_0_5 = DB::select($query)[0]->jumlah;

        $query = "select count(*) as jumlah from terapis as tp join periksas as px on px.id = tp.periksa_id join mereks as mr on mr.id = tp.merek_id join raks as rk on rk.id = mr.rak_id join formulas as fr on fr.id=rk.formula_id join pasiens as ps on ps.id = px.pasien_id where fr.id='150802006' and date(px.tanggal) between '{$mulai}' and '{$akhir}' and TIMESTAMPDIFF(MONTH, ps.tanggal_lahir, px.tanggal) between 6 and 11;";
        $jumlahZink_6_11 = DB::select($query)[0]->jumlah;

        $query = "select count(*) as jumlah from terapis as tp join periksas as px on px.id = tp.periksa_id join mereks as mr on mr.id = tp.merek_id join raks as rk on rk.id = mr.rak_id join formulas as fr on fr.id=rk.formula_id join pasiens as ps on ps.id = px.pasien_id where fr.id='150802006' and date(px.tanggal) between '{$mulai}' and '{$akhir}' and TIMESTAMPDIFF(YEAR, ps.tanggal_lahir, px.tanggal) between 1 and 4;";
        $jumlahZink_1_4 = DB::select($query)[0]->jumlah;

        $query = "select count(*) as jumlah from terapis as tp join periksas as px on px.id = tp.periksa_id join mereks as mr on mr.id = tp.merek_id join raks as rk on rk.id = mr.rak_id join formulas as fr on fr.id=rk.formula_id join pasiens as ps on ps.id = px.pasien_id where fr.id='150811020' and date(px.tanggal) between '{$mulai}' and '{$akhir}' and TIMESTAMPDIFF(YEAR, ps.tanggal_lahir, px.tanggal) > 4;";
        $jumlahOralit_lebih_dari_5 = DB::select($query)[0]->jumlah;

        $query = "select count(*) as jumlah from terapis as tp join periksas as px on px.id = tp.periksa_id join mereks as mr on mr.id = tp.merek_id join raks as rk on rk.id = mr.rak_id join formulas as fr on fr.id=rk.formula_id join pasiens as ps on ps.id = px.pasien_id where fr.id='150811020' and date(px.tanggal) between '{$mulai}' and '{$akhir}' and TIMESTAMPDIFF(YEAR, ps.tanggal_lahir, px.tanggal) < 5;";
        $jumlahOralit_kurang_dari_5 = DB::select($query)[0]->jumlah;

        $query = "select count(*) as jumlah from terapis as tp join periksas as px on px.id = tp.periksa_id join mereks as mr on mr.id = tp.merek_id join raks as rk on rk.id = mr.rak_id join formulas as fr on fr.id=rk.formula_id join diagnosas as dg on dg.id=px.diagnosa_id join pasiens as ps on ps.id = px.pasien_id where fr.id='150802006' and date(px.tanggal) between '{$mulai}' and '{$akhir}' and TIMESTAMPDIFF(MONTH, ps.tanggal_lahir, px.tanggal) between 0 and 5 and (dg.icd10_id like 'a00%' or dg.icd10_id like 'a04%' or dg.icd10_id like 'a06%' or dg.icd10_id like 'a08%' or dg.icd10_id like 'a09%') ;";
        $jumlahZink_0_5_diare = DB::select($query)[0]->jumlah;

        $query = "select count(*) as jumlah from terapis as tp join periksas as px on px.id = tp.periksa_id join mereks as mr on mr.id = tp.merek_id join raks as rk on rk.id = mr.rak_id join formulas as fr on fr.id=rk.formula_id join diagnosas as dg on dg.id=px.diagnosa_id join pasiens as ps on ps.id=px.pasien_id where fr.id='150802006' and date(px.tanggal) between '{$mulai}' and '{$akhir}' and TIMESTAMPDIFF(MONTH, ps.tanggal_lahir, px.tanggal) between 6 and 11 and (dg.icd10_id like 'a00%' or dg.icd10_id like 'a04%' or dg.icd10_id like 'a06%' or dg.icd10_id like 'a08%' or dg.icd10_id like 'a09%') ;";
        $jumlahZink_6_11_diare = DB::select($query)[0]->jumlah;

        $query = "select count(*) as jumlah from terapis as tp join periksas as px on px.id = tp.periksa_id join mereks as mr on mr.id = tp.merek_id join raks as rk on rk.id = mr.rak_id join formulas as fr on fr.id=rk.formula_id join diagnosas as dg on dg.id=px.diagnosa_id join pasiens as ps on ps.id=px.pasien_id where fr.id='150802006' and date(px.tanggal) between '{$mulai}' and '{$akhir}' and TIMESTAMPDIFF(YEAR, ps.tanggal_lahir, px.tanggal) between 1 and 4 and (dg.icd10_id like 'a00%' or dg.icd10_id like 'a04%' or dg.icd10_id like 'a06%' or dg.icd10_id like 'a08%' or dg.icd10_id like 'a09%') ;";
        $jumlahZink_1_4_diare = DB::select($query)[0]->jumlah;
        
        return view('laporans.jumlahDiare', compact(
            'mulai',
            'akhir',
            'jumlahDiare_0_5_L',
            'jumlahDiare_0_5_P',
            'jumlahDiare_6_12_L',
            'jumlahDiare_6_12_P',
            'jumlahDiare_1_4_L',
            'jumlahDiare_1_4_P',
            'jumlahDiare_5_9_L',
            'jumlahDiare_5_9_P',
            'jumlahDiare_10_14_L',
            'jumlahDiare_10_14_P',
            'jumlahDiare_15_19_L',
            'jumlahDiare_15_19_P',
            'jumlahDiare_20_L',
            'jumlahDiare_20_P',
            'jumlahDiare',
            'jumlahZink_0_5',
            'jumlahZink_1_4',
            'jumlahZink_6_11',
            'jumlahOralit_kurang_dari_5',
            'jumlahOralit_lebih_dari_5',
            'jumlahZink_0_5_diare',
            'jumlahZink_6_11_diare',
            'jumlahZink_1_4_diare'
        ));

        $data = '';

        $data .= 'jumlahDiare_0_5_L = ' . $jumlahDiare_0_5_L . '<br />';
        $data .= 'jumlahDiare_0_5_P = ' . $jumlahDiare_0_5_P . '<br />';
        $data .= 'jumlahDiare_6_12_L = ' . $jumlahDiare_6_12_L . '<br />';
        $data .= 'jumlahDiare_6_12_P = ' . $jumlahDiare_6_12_P . '<br />';
        $data .= 'jumlahDiare_1_4_L = ' . $jumlahDiare_1_4_L . '<br />';
        $data .= 'jumlahDiare_1_4_P = ' . $jumlahDiare_1_4_P . '<br />';
        $data .= 'jumlahDiare_5_9_L = ' . $jumlahDiare_5_9_L . '<br />';
        $data .= 'jumlahDiare_5_9_P = ' . $jumlahDiare_5_9_P . '<br />';
        $data .= 'jumlahDiare_10_14_L = ' . $jumlahDiare_10_14_L . '<br />';
        $data .= 'jumlahDiare_10_14_P = ' . $jumlahDiare_10_14_P . '<br />';
        $data .= 'jumlahDiare_15_19_L = ' . $jumlahDiare_15_19_L . '<br />';
        $data .= 'jumlahDiare_15_19_P = ' . $jumlahDiare_15_19_P . '<br />';
        $data .= 'jumlahDiare_20_L = ' . $jumlahDiare_20_L . '<br />';
        $data .= 'jumlahDiare_20_P = ' . $jumlahDiare_20_P . '<br />';
        $data .= 'jumlahDiare = ' . $jumlahDiare. '<br />';
        $data .= 'jumlahZink_0_5 = ' . $jumlahZink_0_5. '<br />';
        $data .= 'jumlahZink_1_4 = ' . $jumlahZink_1_4. '<br />';
        $data .= 'jumlahZink_6_11 = ' . $jumlahZink_6_11. '<br />';
        $data .= 'jumlahOralit_lebih_dari_5 = ' . $jumlahOralit_lebih_dari_5. '<br />';
        $data .= 'jumlahZink_0_5_diare = ' . $jumlahZink_0_5_diare . '<br />';
        $data .= 'jumlahZink_6_11_diare = ' . $jumlahZink_6_11_diare . '<br />';
        $data .= 'jumlahZink_1_4_diare = ' . $jumlahZink_1_4_diare . '<br />';

        return $data;

    }
	public function hariandanjam()
	{
		// return Input::all();
		$tanggal_awal = Yoga::datePrep(Input::get('tanggal_awal'));
		$tanggal_akhir = Yoga::datePrep(Input::get('tanggal_akhir'));
		$jam_awal = Input::get('jam_awal');
		$jam_akhir = Input::get('jam_akhir');
		$tanggal_awal = $tanggal_awal . ' ' . $jam_awal;
		$tanggal_akhir = $tanggal_akhir . ' ' . $jam_akhir;
		$jenis_tarifs = JenisTarif::all();
		$query = "SELECT *, p.id as periksa_id, ps.nama as nama_pasien, asu.nama as nama_asuransi, p.id as periksa_id, p.poli as poli FROM periksas as p LEFT OUTER JOIN pasiens as ps on ps.id = p.pasien_id LEFT OUTER JOIN asuransis as asu on asu.id = p.asuransi_id where date(p.created_at) between '{$tanggal_awal}' and '{$tanggal_akhir}'";
		$periksas = DB::select($query);
		$query = "SELECT asu.nama , count(asuransi_id) as jumlah, asu.id as id FROM periksas as p left outer join asuransis as asu on p.asuransi_id = asu.id where date(p.created_at) between '{$tanggal_awal}' and '{$tanggal_akhir}' group by asu.nama"; 
		$hariinis = DB::select($query);
		$rincian = [];
		$sama = false;
		// return $periksas;
		foreach ($periksas as $key => $px) {
			$transaksi = $px->transaksi;
			$transaksi = json_decode($transaksi,true);
			// return $px-;
			foreach ($transaksi as $ky => $tr) {
				if (count($rincian) == 0) {
					$rincian[] = $tr['jenis_tarif'];
				} else {
					foreach ($rincian as $k => $rc) {
						if($rc == $tr['jenis_tarif']){
							$sama = true;
							break;
						}
					}
					if (!$sama) {
						$rincian[] = $tr['jenis_tarif'];
					}
					$sama = false;
				}
			}
		}
		$jumlah = 0;
		$piutangJumlah = 0;
		$tunaiJumlah = 0;
		foreach ($periksas as $periksa) {
			$jumlah += (int) $periksa->tunai + (int) $periksa->piutang;
			$piutangJumlah = (int) $periksa->piutang;
			$tunaiJumlah = (int) $periksa->tunai;
		}

		return view('laporans.hariandanjam')
			->withPeriksas($periksas)
			->withRincian($rincian)
			->with('tanggal_awal', $tanggal_awal)
			->with('tanggal_akhir', $tanggal_akhir)
			->with('jenis_tarifs', $jenis_tarifs)
			->withPiutangjumlah($piutangJumlah)
			->withHariinis($hariinis)
			->withTunaijumlah($tunaiJumlah);
	}
	public function asuransi_detail($asuransi_id, $tanggal){
		$periksas = Periksa::where("tanggal", $tanggal)->paginate(4);
		return view('laporans.lebih_detail.harian_per_asuransi', compact('periksas'));
	}
	public function contoh(){

		$data = ['nama1', 'nama2', 'nama3'];
		$i = 0;
		$result = '';
		while ( $i < count( $data ) ){
			if ($i == 2) {
				$result = $data[$i];
				break;
			}
			$i++;
		}
		return $result;



	}
	private function poliIni($tanggal, $asuransi_id =  '%'){
		$periksa = new Periksa;
		return $periksa->poliIni($tanggal, $asuransi_id);
	}

	private function unique($arr, $param){
		$uniqueEmails = array();
		foreach($arr as $array)
		{
			if(!in_array($array->$param, $uniqueEmails)){
				$uniqueEmails[] = $array->$param;
			}
		}
		return $uniqueEmails;
	}

	public function smsBpjs(){
		$tanggall       = Input::get('bulanTahun');
		$tanggal		= Yoga::blnPrep($tanggall);
		$sms_kontak		= SmsKontak::with('pasien')
							->where('created_at', 'like', $tanggal. '%')
							->where('pcare_submit', '0')
							->orderBy('pcare_submit')
							->get();

		//=======================================================
		//$sms_test		= SmsKontak::with('pasien')
									//->where('created_at', 'like', $tanggal. '%')
									//->where('pcare_submit','2')
									//->orderBy('pcare_submit')
									//->get();
		//=======================================================
		$sms_masuk		= SmsKontak::with('pasien')
									->where('created_at', 'like', $tanggal. '%')
									->where('pcare_submit', '1')
									->get();
		$sms_gagal		= SmsGagal::where('created_at', 'like', $tanggal. '%')->get();
		$pcare_submits  = PcareSubmit::pluck('pcare_submit', 'id');
		return view('laporans.sms_bpjs', compact(
			'sms_kontak',
			'sms_masuk',
			'sms_gagal',
			'pcare_submits'
		));
	}
	
	
	private function count($id){

		// cek Berapa Kali Pengantar ini berobat
		$berapaKaliPeriksa = Periksa::where('pasien_id', $id)
		->where('tanggal', 'like', date('Y-m') . '%') 
		->count() ;
		if ($berapaKaliPeriksa > 0) {
			return $berapaKaliPeriksa;
		}

		// cek Berapa Kali Pengantar ini mengantar
		$berapaKaliPengantar = PengantarPasien::with('pengantar')->where('pengantar_id', $id)
		->where('created_at', 'like', date('Y-m') . '%') 
		->where('pcare_submit', 1)
		->count() ;

		if ($berapaKaliPengantar > 0) {
			return $berapaKaliPengantar;
		}

		$query = "SELECT count(ks.id) as jumlah FROM kunjungan_sakits as ks join periksas as px on ks.periksa_id = px.id join pasiens as ps on ps.id = px.pasien_id ";
		$query .= "WHERE ks.created_at like '" . date('Y-m') . "%' ";
		$query .= "AND ks.pcare_submit = 1 ";
		$query .= "AND px.pasien_id = '" . $id . "';";

		$countKunjunganSakit = DB::select($query)[0]->jumlah;

		if ($countKunjunganSakit > 0) {
			return $countKunjunganSakit;
		}

		return 0;
		 
	}

	public function postKunjunganSakit(){
	}
	public function dispensingBpjs(){
		$staf_id = Input::get('id');
		$bulanTahun = Yoga::bulanTahun( Input::get('mulai') );

		$query  = "SELECT ";
		$query .= "count(px.id) as jumlah, ";
		$query .= "st.id as staf_id, ";
		$query .= "st.nama as nama_staf ";
		$query .= "FROM periksas as px ";
		$query .= "JOIN stafs as st on st.id = px.staf_id ";
		$query .= "WHERE st.id like '{$staf_id}'";
		$query .= "AND px.tanggal like '{$bulanTahun}%'";
		$query .= "AND px.asuransi_id = 32 ";
		$query .= "GROUP BY st.id ";
		$pasiens = DB::select($query);
		$pasien_array = [];
		foreach ($pasiens as $p) {
			$pasien_array[ $p->staf_id ] = $p->jumlah;
		}
		$query  = "SELECT staf_id, ";
		$query .= "harga_beli_satuan, ";
		$query .= "harga_jual_satuan, ";
		$query .= "jumlah, ";
		$query .= "st.id as staf_id, ";
		$query .= "st.nama as nama_staf ";
		$query .= "FROM terapis as tx ";
		$query .= "JOIN periksas as px on px.id = tx.periksa_id ";
		$query .= "JOIN stafs as st on st.id = px.staf_id ";
		$query .= "WHERE asuransi_id = 32 ";
		$query .= "AND staf_id like '{$staf_id}' ";
		$query .= "AND tanggal like '{$bulanTahun}%' ";
		//return $query;
		$datas = DB::select($query);


		$array = [];
		foreach ($datas as $d) {
			if (isset($array[$d->staf_id])) {
				$jumlah_harga_beli = $array[$d->staf_id]['jumlah_harga_beli'] + ( $d->harga_beli_satuan * $d->jumlah );
				$jumlah_harga_jual = $array[$d->staf_id]['jumlah_harga_jual'] + ( $d->harga_jual_satuan * $d->jumlah );
				$array[$d->staf_id] = [
					'nama_staf'             => $d->nama_staf,
					'jumlah_harga_beli'     => $jumlah_harga_beli,
					'jumlah_harga_jual'     => $jumlah_harga_jual,
					'jumlah_pasien'         => $pasien_array[$d->staf_id],
					'dispensing_per_pasien' => $jumlah_harga_beli / $pasien_array[$d->staf_id]
				];
			} else {
				$array[$d->staf_id] = [
					'nama_staf'             => $d->nama_staf,
					'jumlah_harga_beli'     => 0,
					'jumlah_harga_jual'     => 0,
					'jumlah_pasien'         => $pasien_array[$d->staf_id],
					'dispensing_per_pasien' => 0
				];
			}
		}
		usort($array, function($a, $b) {
			return $a['dispensing_per_pasien'] <=> $b['dispensing_per_pasien'];
		});
		return view('laporans.dipensingObatBpjs', compact(
			'array'
		));
	}
	public function jumlahPasienBaru($bulanIni, $id_bulan_ini, $asuransi_id = '%'){

		$query  = "SELECT count(distinct ps.id) as jumlah_periksa ";
		$query .= "FROM periksas as px join pasiens as ps on ps.id = px.pasien_id ";
		$query .= "WHERE ps.created_at like '{$bulanIni}%'";
		$query .= "AND px.tanggal like '{$bulanIni}%'";
		$query .= "AND px.asuransi_id like '{$asuransi_id}%'";

		return DB::select($query)[0]->jumlah_periksa;
	}
	public function hariinis($tanggal, $asuransi_id = '%'){
		$query = "SELECT ";
		$query .= "asu.nama , ";
		$query .= "count(asuransi_id) as jumlah, ";
		$query .= "asu.id as id ";
		$query .= "FROM periksas as p left outer join asuransis as asu on p.asuransi_id = asu.id ";
		$query .= "where p.tanggal = '" . $tanggal . "' AND asu.id like '" . $asuransi_id . "' ";
		$query .= "group by asu.nama";

		return DB::select($query);
	}

	public function periksaHarian($tanggal, $asuransi_id = '%'){

		$query  = "SELECT *, ";
		$query .= "p.id as periksa_id, ";
		$query .= "p.tanggal as tanggal, ";
		$query .= "p.asuransi_id as asuransi_id, ";
		$query .= "ps.nama as nama_pasien, ";
		$query .= "asu.nama as nama_asuransi, ";
		$query .= "p.id as periksa_id, ";
		$query .= "p.poli as poli ";
		$query .= "FROM periksas as p LEFT OUTER JOIN pasiens as ps on ps.id = p.pasien_id ";
		$query .= "LEFT OUTER JOIN asuransis as asu on asu.id = p.asuransi_id ";
		$query .= "where p.tanggal like '{$tanggal}' ";
		$query .= "AND p.asuransi_id like '{$asuransi_id}' ";
		return  DB::select($query);

	}
	public function polisHarian($periksas){
		$poli_id = [];
		foreach ($periksas as $periksa) {
			$poli_id[] = $periksa->poli;
		}
		$polis = array_unique($poli_id, SORT_REGULAR);
		sort( $polis );
		return $polis;
	}
	public function omsetEstetik(){
		$query  = "SELECT sum(tunai) as tunai, ";
		$query .= "count(id) as jumlah_pasien, ";
		$query .= "DATE_FORMAT(created_at, '%Y %M') as bulan ";
		$query .= "FROM periksas ";
		$query .= "WHERE poli = 'estetika' ";
		$query .= "GROUP BY Year(created_at), Month(created_at)";
		$omsets = DB::select($query);
		return view('laporans.omset_estetik', compact(
			'omsets'
		));
	}
	public function jumlahPenyakitTBCTahunan(){
		$tahun = Input::get('tahun');
		$query  = "SELECT ";
		$query .= "ps.nama as nama, ";
		$query .= "ps.sex as sex, ";
		$query .= "ps.tanggal_lahir as tanggal_lahir, ";
		$query .= "ps.alamat as alamat, ";
		$query .= "icd.diagnosaICD as diagnosa, ";
		$query .= "icd.id as icd ";
		$query .= "FROM periksas as px ";
		$query .= "JOIN diagnosas as dx on dx.id = px.diagnosa_id ";
		$query .= "JOIN icd10s as icd on icd.id = dx.icd10_id ";
		$query .= "JOIN pasiens as ps on ps.id = px.pasien_id ";
		$query .= "WHERE icd.id like 'A15%'";
		$query .= "AND px.created_at like '{$tahun}%' ";
		$query .= "GROUP BY px.pasien_id";
		$data = DB::select($query);

		return view('laporans.jumlahPasienTBCTahunan', compact(
			'data',
			'tahun'
		));
	}
	public function jumlahPenyakitDM_HT(){

		$bulanTahun = Input::get('bulanTahun');

		$bulanTahun = Yoga::bulanTahun($bulanTahun);



		$query  = "SELECT ";
		$query .= "ps.nama as nama_pasien, ";
		$query .= "st.nama as nama_pemeriksa, ";
		$query .= "px.tanggal as tanggal_berobat, ";
		$query .= "px.sistolik as sistolik, ";
		$query .= "px.diastolik as diastolik, ";
		$query .= "dx.icd10_id as icd10_id, ";
		$query .= "px.pemeriksaan_fisik as pf, ";
		$query .= "px.pemeriksaan_penunjang as pj, ";
		$query .= "dx.diagnosa as diagnosa ";
		$query .= "FROM periksas as px ";
		$query .= "JOIN diagnosas as dx on dx.id = px.diagnosa_id ";
		$query .= "JOIN pasiens as ps on ps.id = px.pasien_id ";
		$query .= "JOIN stafs as st on st.id = px.staf_id ";
		$query .= "WHERE ( dx.icd10_id like 'I1%' OR dx.icd10_id like 'E1%' ) ";
		$query .= "AND px.created_at like '{$bulanTahun}%' ";
		$periksas = DB::select($query);

		$bulanTahun = Input::get('bulanTahun');

		$data = [];

		foreach ($periksas as $periksa) {
			if (substr($periksa->icd10_id, 0, 2) == 'I1'	) {
				$data['ht'][] = $periksa;
			} else {
				$data['dm'][] = $periksa;
			}
		}

		return view('laporans.jumlah_pasien_dm_ht', compact(
			'bulanTahun',
			'data',
			'periksas'
		));
	}
	public function extractId($data, $attr_id){
		$ids = [];
		foreach ($data as $d) {
			$ids[] = $d->$attr_id;
		}
		return $ids;
	}
	public function angkaKontakBelumTerpenuhi(){
		$tahunBulan = date('Y-m');

		$query  = "SELECT ";
		$query .= "ps.nama as nama_pasien, ";
		$query .= "ps.no_telp as no_telp, ";
		$query .= "ps.alamat as alamat, ";
		$query .= "ps.alamat as alamat, ";
		$query .= "ps.nomor_asuransi_bpjs as nomor_asuransi_bpjs, ";
		$query .= "count(px.pasien_id) as kali_berobat ";
		$query .= "FROM pasiens as ps ";
		$query .= "JOIN periksas as px on px.pasien_id = ps.id ";
		$query .= "WHERE nomor_asuransi_bpjs not like '' and nomor_asuransi_bpjs is not null ";
		$query .= "AND ( ps.id not in( Select pengantar_id from pengantar_pasiens where created_at like '{$tahunBulan}%' and pcare_submit = 1 )";
		// yang termsuk  sms_kontaks yang sudah di sms yang dimasukkan di pcare_submit
		$query .= "AND  ps.id not in( Select pasien_id from sms_kontaks where created_at like '{$tahunBulan}%' and pcare_submit = 1 )";
		// yang termsuk  pasien bpjs yang mengunakan Pembayaran non bpjs
		$query .= "AND  ps.id not in( Select px.pasien_id from kunjungan_sakits as ks join periksas as px on px.id = ks.periksa_id where ks.created_at like '{$tahunBulan}%' and ks.pcare_submit = 1 ) ";
		// yang termsuk  pasien bpjs yang mengunakan Pembayaran bpjs
		$query .= "AND  ps.id not in( Select pasien_id from periksas where asuransi_id = 32 and created_at like '{$tahunBulan}%' )) ";
		$query .= "group by px.pasien_id, ps.alamat ";
		$query .= "order by kali_berobat ";
		$query .= "LIMIT 20;";
		
		$data = DB::select($query);
		return view('laporans.angka_kontak_belum_terpenuhi', compact(
			'data'
		));
	}
	public function angkaKontakBpjs(){
		return view('laporans.angka_kontak_bpjs');
	}
	public function PengantarPasienBpjs(){
		return view('laporans.kunjungan_sehat_bpjs');
	}
	public function KunjunganSakitBpjs(){
		return view('laporans.kunjungan_sakit_bpjs');
	}
	public function homeVisit(){
		return view('laporans.home_visit');
	}
	public function angkaKontakBpjsBulanIni(){
		return view('laporans.angka_kontak_bpjs_bulan_ini');
	}
	public function updateAsuransi(){
		try {
			$periksa_id              = Input::get('periksa_id');
			$asuransi_id             = Input::get('asuransi_id');
				
			$periksa_id              = Periksa::find($periksa_id);
			$periksa_id->asuransi_id = $asuransi_id;
			$periksa_id->save();

			$pasien                  = Pasien::find( $periksa->pasien_id );
			$pasien->asuransi_id     = $asuransi_id;
			$pasien->save();

			return 1;
		} catch (\Exception $e) {
			return 0;
		}

	}
	public function pph21(){

		$bulanTahun    = Carbon::createFromFormat('m-Y', Input::get('bulanTahun'));
		$bayar_gajis   = BayarGaji::with('staf')->where('mulai', 'like', $bulanTahun->format('Y-m') . '%')->get();
		$bayar_dokters = BayarDokter::with('staf')->where('mulai', 'like', $bulanTahun->format('Y-m') . '%')->get();

		dd( $bulanTahun->format('F Y') );

		$query  = "SELECT ";
		$query .= "stf.nama, ";
		$query .= "stf.npwp, ";
		$query .= "stf.jenis_kelamin, ";
		$query .= "byd.menikah, ";
		$query .= "byd.jumlah_anak, ";
		$query .= "sum(byd.bayar_dokter) as bayar_dokter, ";
		$query .= "sum(byd.potongan5persen_setahun) as potongan5persen, ";
		$query .= "sum(byd.potongan15persen_setahun) as potongan15persen, ";
		$query .= "sum(byd.potongan25persen_setahun) as potongan25persen, ";
		$query .= "sum(byd.potongan30persen_setahun) as potongan30persen ";
		$query .= "FROM bayar_dokters as byd ";
		$query .= "JOIN stafs as stf on stf.id = byd.staf_id ";
		$query .= "WHERE mulai like '{$bulanTahun->format('Y-m')}%'";
		$query .= "GROUP BY stf.id ";
		/* dd( $query ); */
		$bayar_dokters = DB::select($query);

		return view('laporans.pph21', compact(
			'bayar_gajis',
			'bulanTahun',
			'bayar_dokters'
		));
		
	}
	public function cariJumlahProlanis($bulanTahun){
		$rppt = PesertaBpjsPerbulan::where('bulanTahun', 'like', $bulanTahun . '%')->latest()->first();
		$jumlah_prolanis_dm = $rppt == null? 0 : $rppt->jumlah_dm;
		$jumlah_prolanis_ht = $rppt == null? 0 : $rppt->jumlah_ht;
		return compact(
			'jumlah_prolanis_dm',
			'jumlah_prolanis_ht'
		);
	}
	public function cariStatusHt($bulanTahun, $jumlah_prolanis_ht){
		$pdf           = new PdfsController;
		$prolanis_ht   = [];
		$ht_berobat    = 0;
		$ht_terkendali = 0;
		$prolanis_ht   = $pdf->prolanisHT($bulanTahun);
		foreach ($prolanis_ht as $p) {
			if ( $pdf->htTerkendali($p) ) {
				$ht_terkendali++;
			}
		}
		$ht_berobat    = count($prolanis_ht);
		$ht_terkendali_persen = $jumlah_prolanis_ht > 0 ? round($ht_terkendali / $jumlah_prolanis_ht * 100): 0;

		return compact(
			'ht_terkendali_persen',
			'ht_berobat',
			'ht_terkendali'
		);
	}
	/**
	* undocumented function
	*
	* @return void
	*/
	private function getHariIni($periksa_hari_ini)
	{

		$polis         = [];
		foreach ($periksa_hari_ini as $prx) {
			if (!isset($polis[$prx->poli])) {
				$polis[$prx->poli] = 1;
			} else {
				$polis[$prx->poli]++;
			}
		}
		ksort($polis);

		$hariinis = [];
		foreach ($periksa_hari_ini as $prx) {
			foreach ($polis as $k => $pl) {
				if (!isset($hariinis[ $prx->asuransi_id ]['by_poli'][$k])) {
					$hariinis[ $prx->asuransi_id ]['by_poli'][$k] = 0;
				}
			}
			$hariinis[ $prx->asuransi_id ]['nama_asuransi'] = $prx->nama_asuransi;
			$hariinis[ $prx->asuransi_id ]['asuransi_id'] = $prx->asuransi_id;
			if (!isset($hariinis[ $prx->asuransi_id ]['jumlah_hari_ini'])) {
				$hariinis[ $prx->asuransi_id ]['jumlah_hari_ini'] = 1;
			} else {
				$hariinis[ $prx->asuransi_id ]['jumlah_hari_ini']++;
			}

			if (!isset($hariinis[ $prx->asuransi_id ]['by_poli'][$prx->poli])) {
				$hariinis[ $prx->asuransi_id ]['by_poli'][$prx->poli] = 1;
			} else {
				$hariinis[ $prx->asuransi_id ]['by_poli'][$prx->poli]++;
			}
		}

		usort($hariinis, function($a, $b) {
			return $a['asuransi_id'] <=> $b['asuransi_id'];
		});
		return [
			'hariinis' => $hariinis,
			'polis' => $polis
		];
	}
	public function cariTransaksi(){
		return view('laporans.cari_transaksi');
	}
	public function cariTransaksiAjax(){
		$tanggal       = Input::get('tanggal');
		$nama_asuransi = Input::get('nama_asuransi');
		$nama_pasien   = Input::get('nama_pasien');
		$tunai         = Input::get('tunai');
		$piutang       = Input::get('piutang');
		$sudah_dibayar = Input::get('sudah_dibayar');

		$query  = "SELECT ";
		$query .= "prx.tanggal as tanggal, ";
		$query .= "psn.nama as nama_pasien, ";
		$query .= "asu.nama as nama_asuransi, ";
		$query .= "prx.id as periksa_id, ";
		$query .= "psn.id as pasien_id, ";
		$query .= "prx.tunai as tunai, ";
		$query .= "prx.piutang as piutang, ";
		$query .= "COALESCE(sum(pdb.pembayaran),0) as sudah_dibayar ";
		$query .= "FROM periksas as prx ";
		$query .= "JOIN pasiens as psn on psn.id = prx.pasien_id ";
		$query .= "left JOIN piutang_dibayars as pdb on pdb.periksa_id = prx.id ";
		$query .= "JOIN asuransis as asu on asu.id = prx.asuransi_id ";
		$query .= "WHERE ( prx.tanggal like '{$tanggal}%' or '{$tanggal}' = '' ) ";
		$query .= "AND ( psn.nama like '{$nama_pasien}%' or '{$nama_pasien}' = '' ) ";
		$query .= "AND ( asu.nama like '%{$nama_asuransi}%' or '{$nama_asuransi}' = '' ) ";
		$query .= "AND ( prx.tunai like '{$tunai}%' or '{$tunai}' = '' ) ";
		$query .= "AND ( prx.piutang like '{$piutang}%' or '{$piutang}' = '' ) ";
		$query .= "AND prx.piutang is not null ";
		$query .= "GROUP BY prx.id ";
		$query .= "LIMIT 20 ";
		$data = DB::select($query);
		return $data;
	}
	
}
