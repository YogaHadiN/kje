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
use App\Models\Poli;
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

	public function bpjsTidakTerpakai($tanggall){
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

		$query  = "SELECT *, ";
		$query .= "asu.nama as nama_asuransi ";
		$query .= "FROM periksas as prx ";
		$query .= "LEFT OUTER JOIN asuransis as asu on asu.id = prx.asuransi_id ";
		$query .= "WHERE prx.tanggal between '{$bulanIni}-01' and '" . date("Y-m-t", strtotime($bulanIni. "-01")) . "' ";
		$query .= "and prx.tenant_id = " . session()->get('tenant_id') . " ";

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
		$query .= "and prx.tenant_id = " . session()->get('tenant_id') . " ";
		$query .= "GROUP BY psn.id ";
		$query .= "ORDER BY prx.sistolik asc ";
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
		$query .= "and prx.tenant_id = " . session()->get('tenant_id') . " ";
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
		$query .= "WHERE id like '{$id_hari_ini}%' ";
		$query .= "and tenant_id = " . session()->get('tenant_id') . " ";
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
		$query = "SELECT *, ";
		$query .= "ps.nama as nama_pasien, ";
		$query .= "asu.nama as nama_asuransi, ";
		$query .= "p.id as periksa_id, ";
		$query .= "d.icd10_id as icd10 ";
		$query .= "FROM periksas as p ";
		$query .= "LEFT OUTER JOIN pasiens as ps on ps.id = p.pasien_id ";
		$query .= "LEFT OUTER JOIN asuransis as asu on asu.id = p.asuransi_id ";
		$query .= "join diagnosas as d on d.id=p.diagnosa_id ";
		$query .= "where p.tanggal like '{$tanggal}' ";
		$query .= "and p.tenant_id = " . session()->get('tenant_id') . " ";
		$query .= "AND p.asuransi_id like '{$asuransi_id}'";
		$periksas = DB::select($query);


		$query = "SELECT asu.nama , ";
		$query .= "count(asuransi_id) as jumlah, ";
		$query .= "asu.id as id ";
		$query .= "FROM periksas as p ";
		$query .= "left outer join asuransis as asu on p.asuransi_id = asu.id ";
		$query .= "where p.tanggal = '" . $tanggal . "' ";
		$query .= "AND asu.id like '" . $asuransi_id . "' ";
		$query .= "AND p.tenant_id = " . session()->get('tenant_id') . " ";
		$query .= " group by asu.nama" ;
		$hariinis = DB::select($query);

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
		$query = "SELECT *, ";
		$query .= "ps.nama as nama_pasien, ";
		$query .= "asu.nama as nama_asuransi, ";
		$query .= "p.id as periksa_id, ";
		$query .= "p.transaksi as transaksi ";
		$query .= "FROM periksas as p ";
		$query .= "LEFT OUTER JOIN pasiens as ps on ps.id = p.pasien_id ";
		$query .= "LEFT OUTER JOIN asuransis as asu on asu.id = p.asuransi_id ";
		$query .= "where p.tanggal like '{$tanggal}' ";
		$query .= "and p.tenant_id = " . session()->get('tenant_id') . " ";
		$query .= "AND p.asuransi_id like '{$asuransi_id}'";
		$periksas = DB::select($query);



		$query = "SELECT asu.nama , count(asuransi_id) as jumlah, asu.id as id FROM periksas as p left outer join asuransis as asu on p.asuransi_id = asu.id ";
		$query .= "where p.tanggal = '" . $tanggal . "' ";
		$query .= "AND asu.id like '" . $asuransi_id . "' ";
		$query .= "AND p.tenant_id = " . session()->get('tenant_id') . " ";
		$query .= " group by asu.nama" ;
		$hariinis = DB::select($query);

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

		$query = "SELECT ps.nama as nama_pasien, ";
		$query .= "p.id as periksa_id, ";
		$query .= "s.nama as nama, ";
		$query .= "s.id as id, ";
		$query .= "count(s.id) as jumlah, ";
		$query .= "sum(p.tunai) as tunai, ";
		$query .= "sum(p.piutang) as piutang ";
		$query .= "from periksas as p ";
		$query .= "LEFT OUTER JOIN asuransis as s on s.id = p.asuransi_id join pasiens as ps on ps.id = p.pasien_id ";
		$query .= "where p.tanggal like '{$tanggal}%' ";
		$query .= "AND p.asuransi_id like '{$asuransi_id}' ";
		$query .= "AND p.tenant_id = " . session()->get('tenant_id') . " ";
		$query .= "GROUP BY s.nama ";
		$query .= "ORDER BY jumlah desc";
		$bulan = DB::select($query);



		$query = "select count(*) as jumlah ";
		$query .= "from ( ";
		$query .= "SELECT count(pasien_id) as angka_kontak ";
		$query .= "FROM periksas  as px ";
		$query .= "JOIN asuransis as asu on asu.id = px.asuransi_id ";
		$query .= "where asu.tipe_asuransi_id=5 ";
		$query .= "AND px.tanggal like '$tanggal%' ";
		$query .= "AND px.tenant_id = " . session()->get('tenant_id') . " ";
		$query .= "group by px.pasien_id ";
		$query .= " ) as x";
		$angka_kontak = DB::select($query)[0]->jumlah;


		$query = "select count(*) as jumlah ";
		$query .= "from ";
		$query .= "( SELECT * ";
		$query .= "FROM periksas  as px ";
		$query .= "JOIN asuransis as asu on asu.id = px.asuransi_id ";
		$query .= "where asu.tipe_asuransi_id=5 ";
		$query .= "AND px.tanggal like '$tanggal%' ";
		$query .= "AND px.tenant_id = " . session()->get('tenant_id') . " ";
		$query .= ") as x";
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
		$query = "SELECT p.tanggal, ";
		$query .= "min(s.nama), ";
		$query .= "count(p.id) as jumlah, ";
		$query .= "sum(p.tunai) as tunai, ";
		$query .= "sum(p.piutang) as piutang ";
		$query .= "FROM periksas as p ";
		$query .= "left outer join asuransis as s on s.id = p.asuransi_id ";
		$query .= "where p.tanggal like '{$tanggal}%' ";
		$query .= "AND asuransi_id like '{$asuransi_id}' ";
		$query .= "AND p.tenant_id = " . session()->get('tenant_id') . " ";
		$query .= "group by p.tanggal";
		$tanggal = DB::select($query);
		$bln = Input::get('bulanTahun');


		$date = Yoga::blnPrep(Input::get('bulanTahun'));
 
		$query = "SELECT p.asuransi_id as asuransi_id, ";
		$query .= "p.tanggal as tanggal, ";
		$query .= "asu.nama as asuransi, ";
		$query .= "count(*) as jumlah, ";
		$query .= "sum(p.tunai) as tunai, ";
		$query .= "sum(p.piutang) as piutang ";
		$query .= "from periksas as p ";
		$query .= "join asuransis as asu on asu.id = p.asuransi_id ";
		$query .= "where p.tanggal like '{$date}%' ";
		$query .= "AND p.tenant_id = " . session()->get('tenant_id') . " ";
		$query .= "group by p.tanggal, ";
		$query .= "p.asuransi_id";
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
		/* dd(Input::all()); */ 

		$tanggal 		= Yoga::blnPrep(Input::get('bulanTahun'));
		$asuransi_id 	= Input::get('asuransi_id');

		$query = "SELECT icd.diagnosaICD as diagnosaICD, ";
		$query .= "p.tanggal, ";
		$query .= "ps.nama, ";
		$query .= "s.nama as nama_asuransi, ";
		$query .= "p.tunai as tunai, ";
		$query .= "p.piutang as piutang, ";
		$query .= "p.transaksi as transaksi, ";
		$query .= "sum(tr.harga_beli_satuan * tr.jumlah) as modal_obat, ";
		$query .= "p.id as periksa_id, ";
		$query .= "p.created_at as created_at ";
		$query .= "FROM terapis as tr ";
		$query .= "join periksas as p on p.id = tr.periksa_id ";
		$query .= "left outer join asuransis as s on s.id = p.asuransi_id ";
		$query .= "left outer join pasiens as ps on ps.id = p.pasien_id ";
		$query .= "join diagnosas as dg on dg.id = p.diagnosa_id ";
		$query .= "join icd10s as icd on icd.id = dg.icd10_id ";
		$query .= "where p.tanggal like '{$tanggal}%' ";
		$query .= "AND p.asuransi_id like '{$asuransi_id}' ";
		$query .= "AND tr.tenant_id = " . session()->get('tenant_id') . " ";
		$query .= "group by p.id order by p.id desc";

		if ($asuransi_id == '%') {
			$nama_asuransi = 'Semua Pembayaran';
		} else {
			$nama_asuransi = Asuransi::find($asuransi_id)->nama;
		}
		$data = DB::select($query);

		$modal = 0;

		$rincian = Yoga::rincian($data);
		$tanggall = $tanggal;

		return view('laporans.detbulan')
			->withTanggall($tanggall)
			->withTanggal($data)
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
			$pn = new NotaJual;
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
				$jurnal->coa_id          = Coa::where('kode_coa', '110000')->first()->id; // Kas di tangan
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

		$query = "SELECT i.id, i.diagnosaICD, ";
		$query .= "count(p.id) as jumlah ";
		$query .= "FROM periksas as p ";
		$query .= "left outer join asuransis as s on s.id = p.asuransi_id ";
		$query .= "left outer join pasiens as ps on ps.id = p.pasien_id ";
		$query .= "left outer join diagnosas as dg on dg.id = p.diagnosa_id ";
		$query .= "left outer join icd10s as i on i.id = dg.icd10_id ";
		$query .= "where p.tanggal >= '{$mulai}' ";
		$query .= "AND p.tanggal <= '{$akhir}' ";
		$query .= "AND p.tenant_id = " . session()->get('tenant_id') . " ";
		$query .= "AND p.asuransi_id like '{$asuransi_id}' ";
		$query .= "group by i.id order by jumlah desc";
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
		$query .= "and pn.tenant_id = " . session()->get('tenant_id') . " ";
		$query .= "group by nama";


		$points = DB::select($query);

		return view('laporans.poin', compact('points'));

	}
	public function pendapatan()
	{
		$mulai = Input::get('mulai');
		$akhir = Input::get('akhir');

		$mulai = Yoga::nowIfEmptyMulai($mulai);
		$akhir = Yoga::nowIfEmptyAkhir($akhir);

		$pendapatans = Pendapatan::whereRaw("created_at between '{$mulai}' and '{$akhir}'")->get();

		return view('laporans.pendapatan', compact('pendapatans', 'mulai', 'akhir'));



	}

	public function rujukankebidanan(){
		$mulai = Input::get('mulai');
		$akhir = Input::get('akhir');

		$mulai = Yoga::nowIfEmptyMulai($mulai);
		$akhir = Yoga::nowIfEmptyAkhir($akhir);

		$query = "SELECT ps.nama as nama_pasien, ";
		$query .= "icd.id as icd10_id, ";
		$query .= "ps.tanggal_lahir as tanggal_lahir, ";
		$query .= "icd.diagnosaICD as diagnosa, ";
		$query .= "tj.tujuan_rujuk as tujuan_rujuk, ";
		$query .= "px.tanggal as tanggal, ";
		$query .= "rj.complication as complication ";
		$query .= "from rujukans as rj ";
		$query .= "join periksas as px on px.id = rj.periksa_id ";
		$query .= "join diagnosas as dg on dg.id=px.diagnosa_id ";
		$query .= "join icd10s as icd on icd.id=dg.icd10_id ";
		$query .= "join tujuan_rujuks as tj on tj.id=rj.tujuan_rujuk_id ";
		$query .= "join pasiens as ps on ps.id=px.pasien_id ";
		$query .= "where rj.tujuan_rujuk_id = 24 ";
		$query .= "and rj.tenant_id = " . session()->get('tenant_id') . " ";
		$query .= "and tanggal between '{$mulai}' and '{$akhir}'";
		$rujukans = DB::select($query);

		return view('laporans.rujukankebidanan', compact('rujukans'));
	}
    public function bayardokter(){
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
         
        $coa_id_200001 = Coa::where('kode_coa', 200001)->first()->id;
		$query = "select p.tanggal as tanggal, ";
		$query .= "st.nama as nama_staf, ";
		$query .= "ps.id as pasien_id, ";
		$query .= "ps.nama as nama, ";
		$query .= "asu.nama as nama_asuransi, ";
		$query .= "tunai, ";
		$query .= "piutang, ";
		$query .= "nilai ";
		$query .= " from jurnal_umums as ju ";
		$query .= "join periksas as p on p.id=ju.jurnalable_id ";
		$query .= "join stafs as st on st.id= p.staf_id ";
		$query .= "join pasiens as ps on ps.id=p.pasien_id ";
		$query .= "join asuransis as asu on asu.id=p.asuransi_id ";
		$query .= "where jurnalable_type='App\\\Models\\\Periksa' ";
		$query .= "and p.staf_id='{$id}' ";
		$query .= "and ju.coa_id=  " . $coa_id_200001. " ";
		$query .= "and ju.tenant_id = " . session()->get('tenant_id') . " ";
		$query .= "and ( p.tanggal between '{$mulai}' and '{$akhir}' ) ";
        $hutangs = DB::select($query);
        $total = 0;
        foreach ($hutangs as $hutang) {
            $total += $hutang->nilai;
        }
        return view('gajidokter', compact('hutangs', 'total', 'nama_staf', 'mulai', 'akhir'));
    }

    public function no_asisten(){

		$tanggal  = Yoga::blnPrep(Input::get('bulanTahun'));
        $periksas = Periksa::where('tanggal', 'like', $tanggal . '%')->where('periksa_awal', '[]')->get();
        //return $periksas;
        return view('laporans.no_asisten', compact('periksas'));
    }
    public function gigiBulanan(){
		$tanggal  = Yoga::blnPrep(Input::get('bulanTahun'));
		$poli_id  = Poli::where('poli', 'Poli Gigi')->first()->id;
        $periksas = Periksa::where('tanggal', 'like', $tanggal . '%')->where('poli_id', $poli_id)->get();
        //return $periksas;
        return view('laporans.gigi', compact('periksas'));
    }
    public function anc(){
		$tanggal   = Yoga::blnPrep(Input::get('bulanTahun'));
		$query     = "select px.tanggal as tanggal, ";
		$query    .= "st.nama as nama_staf,";
		$query    .= " px.jam as jam,";
		$query    .= " ps.nama as nama_pasien,";
		$query    .= " po.poli as poli,";
		$query    .= " px.pemeriksaan_fisik as pf";
		$query    .= " from periksas as px";
		$query    .= " join stafs as st on st.id=px.staf_id ";
		$query    .= " join polis as po on po.id=px.poli_id ";
		$query    .= " join pasiens as ps on ps.id=px.pasien_id";
		$query    .= " join diagnosas as dg on dg.id = px.diagnosa_id";
		$query    .= " where st.titel = 'bd'";
		$query    .= " and tanggal like '{$tanggal}%'";
		$query    .= "and px.tenant_id = " . session()->get('tenant_id') . " ";
		$query    .= " and (po.poli = 'poli ANC') ";
        $periksas  = DB::select($query);

		$query = "select min( st.nama ) as nama_staf, ";
		$query .= "count(*) as jumlah ";
		$query .= "from periksas as px ";
		$query .= "join stafs as st on st.id=px.staf_id ";
		$query .= "join pasiens as ps on ps.id=px.pasien_id ";
		$query .= "join diagnosas as dg on dg.id = px.diagnosa_id ";
		$query .= "join polis as po on po.id = px.poli_id ";
		$query .= "where st.titel = 'bd' ";
		$query .= "and tanggal like '{$tanggal}%' ";
		$query .= "and px.tenant_id = " . session()->get('tenant_id') . " ";
		$query .= "and (po.poli = 'poli ANC') group by staf_id ";
        $group_by_stafs = DB::select($query);
        //return $periksas;
        return view('laporans.anc', compact('periksas', 'group_by_stafs'));
    }
    public function kb(){
		$tanggal  = Yoga::blnPrep(Input::get('bulanTahun'));
		$query    = "select px.tanggal as tanggal, ";
		$query   .= "st.nama as nama_staf,";
		$query   .= " px.jam as jam,";
		$query   .= " asu.nama as nama_asuransi,";
		$query   .= " ps.nama as nama_pasien,";
		$query   .= " po.poli as poli,";
		$query   .= " px.pemeriksaan_fisik as pf";
		$query   .= " from periksas as px";
		$query   .= " join polis as po on po.id = px.poli_id ";
		$query   .= " join stafs as st on st.id=px.staf_id";
		$query   .= " join asuransis as asu on asu.id=px.asuransi_id";
		$query   .= " join pasiens as ps on ps.id=px.pasien_id";
		$query   .= " join diagnosas as diag on diag.id = px.diagnosa_id ";
		$query   .= " where st.titel = 'bd' and tanggal like '{$tanggal}%' ";
		$query   .= " and px.tenant_id = " . session()->get('tenant_id') . " ";
		$query   .= " and diag.diagnosa like '%kb%' ";
        $periksas_diagnosa_kb = DB::select($query);

		$query           = "select min( st.nama ) as nama_staf, ";
		$query          .= "count(*) as jumlah ";
		$query          .= "from periksas as px ";
		$query          .= "join stafs as st on st.id=px.staf_id ";
		$query          .= "join pasiens as ps on ps.id=px.pasien_id ";
		$query          .= " join diagnosas as diag on diag.id = px.diagnosa_id ";
		$query          .= " where st.titel = 'bd' ";
		$query          .= " and tanggal like '{$tanggal}%' ";
		$query          .= " and px.tenant_id = " . session()->get('tenant_id') . " ";
		$query          .= " and diag.diagnosa like '%kb%' ";
		$query          .= "group by staf_id ";
        $group_by_stafs  = DB::select($query);
        
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
		$query = "SELECT asu.nama as nama_asuransi, ";
		$query .= "count(*) jumlah ";
		$query .= "FROM periksas as px ";
		$query .= "join asuransis as asu on asu.id=px.asuransi_id ";
		$query .= "where asuransi_id like '{$asuransi_id}' ";
		$query .= "and px.created_at >= '{$mulai} 00:00:00' ";
		$query .= "and px.tenant_id = " . session()->get('tenant_id') . " ";
		$query .= "and px.created_at <= '{$akhir} 00:00:00' ";
		$query .= "GROUP BY px.asuransi_id ";
		$query .= "order by jumlah desc ";
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

		$query             = "select count(*) as jumlah ";
		$query            .= "from periksas as px ";
		$query            .= "join diagnosas as dg on dg.id = px.diagnosa_id ";
		$query            .= "join pasiens as ps on ps.id = px.pasien_id ";
		$query            .= "where date(px.tanggal) between '{$mulai}' and '{$akhir}' ";
		$query            .= "and dg.icd10_id = 'J06' ";
		$query            .= "and px.tenant_id = " . session()->get('tenant_id') . " ";
        if (env("DB_CONNECTION") == 'mysql') {
            $query            .= "and TIMESTAMPDIFF(YEAR, ps.tanggal_lahir, px.tanggal)";
        } else {
            $query            .= "and cast(strftime('%Y.%m%d', 'now') - strftime('%Y.%m%d', ps.tanggal_lahir) as int)";
        }
        $query            .= " = 0 ";
		$query            .= "and ps.sex = 1 ";
        $jumlahIspa_0_1_L  = DB::select($query)[0]->jumlah;

		$query             = "select count(*) as jumlah ";
		$query            .= "from periksas as px ";
		$query            .= "join diagnosas as dg on dg.id = px.diagnosa_id ";
		$query            .= "join pasiens as ps on ps.id = px.pasien_id ";
		$query            .= "where date(px.tanggal) between '{$mulai}' and '{$akhir}' ";
		$query            .= "and px.tenant_id = " . session()->get('tenant_id') . " ";
		$query            .= "and dg.icd10_id = 'J06' ";
        if (env("DB_CONNECTION") == 'mysql') {
            $query            .= "and TIMESTAMPDIFF(YEAR, ps.tanggal_lahir, px.tanggal)";
        } else {
            $query            .= "and cast(strftime('%Y.%m%d', 'now') - strftime('%Y.%m%d', ps.tanggal_lahir) as int)";
        }
        $query .= " between 1 and 5 ";
		$query            .= "and ps.sex = 1 ";
        $jumlahIspa_1_5_L  = DB::select($query)[0]->jumlah;

		$query                  = "select count(*) as jumlah ";
		$query                 .= "from periksas as px ";
		$query                 .= "join diagnosas as dg on dg.id = px.diagnosa_id ";
		$query                 .= "join pasiens as ps on ps.id = px.pasien_id ";
		$query                 .= "where date(px.tanggal) between '{$mulai}' and '{$akhir}' ";
		$query                 .= "and dg.diagnosa like '%pneum%' ";
		$query                 .= "and px.tenant_id = " . session()->get('tenant_id') . " ";
        if (env("DB_CONNECTION") == 'mysql') {
            $query            .= "and TIMESTAMPDIFF(YEAR, ps.tanggal_lahir, px.tanggal)";
        } else {
            $query            .= "and cast(strftime('%Y.%m%d', 'now') - strftime('%Y.%m%d', ps.tanggal_lahir) as int)";
        }
        $query .= " = 0 ";
		$query                 .= "and ps.sex = 1 ";
        $jumlahPneumonia_0_1_L  = DB::select($query)[0]->jumlah;

		$query  = "select count(*) as jumlah ";
		$query .= "from periksas as px ";
		$query .= "join diagnosas as dg on dg.id = px.diagnosa_id ";
		$query .= "join pasiens as ps on ps.id = px.pasien_id ";
		$query .= "where date(px.tanggal) between '{$mulai}' and '{$akhir}' ";
		$query .= "and dg.diagnosa like '%pneum%' ";
		$query .= "and px.tenant_id = " . session()->get('tenant_id') . " ";
        if (env("DB_CONNECTION") == 'mysql') {
            $query            .= "and TIMESTAMPDIFF(YEAR, ps.tanggal_lahir, px.tanggal)";
        } else {
            $query            .= "and cast(strftime('%Y.%m%d', 'now') - strftime('%Y.%m%d', ps.tanggal_lahir) as int)";
        }
        $query .= " between 1 and 5 ";
		$query .= "and ps.sex = 1 ";
        $jumlahPneumonia_1_5_L = DB::select($query)[0]->jumlah;

		$query  = "select count(*) as jumlah ";
		$query .= "from periksas as px ";
		$query .= "join diagnosas as dg on dg.id = px.diagnosa_id ";
		$query .= "join pasiens as ps on ps.id = px.pasien_id ";
		$query .= "where date(px.tanggal) between '{$mulai}' and '{$akhir}' ";
		$query .= "and px.tenant_id = " . session()->get('tenant_id') . " ";
		$query .= "and (dg.icd10_id like 'a00%' or dg.icd10_id like 'a04%' or dg.icd10_id like 'a06%' or dg.icd10_id like 'a08%' or dg.icd10_id like 'a09%') ";
        if (env("DB_CONNECTION") == 'mysql') {
            $query            .= "and TIMESTAMPDIFF(YEAR, ps.tanggal_lahir, px.tanggal)";
        } else {
            $query            .= "and cast(strftime('%Y.%m%d', 'now') - strftime('%Y.%m%d', ps.tanggal_lahir) as int)";
        }
        $query .= " = 0 ";
		$query .= "and ps.sex = 1 ";
        $jumlahDiare_0_1_L = DB::select($query)[0]->jumlah;

		$query  = "select count(*) as jumlah ";
		$query .= "from periksas as px ";
		$query .= "join diagnosas as dg on dg.id = px.diagnosa_id ";
		$query .= "join pasiens as ps on ps.id = px.pasien_id ";
		$query .= "where date(px.tanggal) between '{$mulai}' and '{$akhir}' ";
		$query .= "and px.tenant_id = " . session()->get('tenant_id') . " ";
		$query .= "and ";
		$query .= "(dg.icd10_id like 'a00%' ";
		$query .= "or dg.icd10_id like 'a04%' ";
		$query .= "or dg.icd10_id like 'a06%' ";
		$query .= "or dg.icd10_id like 'a08%' ";
		$query .= "or dg.icd10_id like 'a09%') ";
        if (env("DB_CONNECTION") == 'mysql') {
            $query            .= "and TIMESTAMPDIFF(YEAR, ps.tanggal_lahir, px.tanggal)";
        } else {
            $query            .= "and cast(strftime('%Y.%m%d', 'now') - strftime('%Y.%m%d', ps.tanggal_lahir) as int)";
        }
        $query .= " between 1 and 5 ";
		$query .= "and ps.sex = 1 ";
        $jumlahDiare_1_5_L = DB::select($query)[0]->jumlah;

		$query  = "select count(*) as jumlah ";
		$query .= "from periksas as px ";
		$query .= "join diagnosas as dg on dg.id = px.diagnosa_id ";
		$query .= "join pasiens as ps on ps.id = px.pasien_id ";
		$query .= "where date(px.tanggal) between '{$mulai}' and '{$akhir}' ";
		$query .= "and px.tenant_id = " . session()->get('tenant_id') . " ";
		$query .= "and dg.icd10_id = 'J06' ";
        if (env("DB_CONNECTION") == 'mysql') {
            $query            .= "and TIMESTAMPDIFF(YEAR, ps.tanggal_lahir, px.tanggal)";
        } else {
            $query            .= "and cast(strftime('%Y.%m%d', 'now') - strftime('%Y.%m%d', ps.tanggal_lahir) as int)";
        }
        $query .= " > 5 ";
		$query .= "and ps.sex = 1 ";
        $jumlahIspaBukanPneumonia_diatas_5_tahun_L = DB::select($query)[0]->jumlah;

		$query  = "select count(*) as jumlah ";
		$query .= "from periksas as px ";
		$query .= "join diagnosas as dg on dg.id = px.diagnosa_id ";
		$query .= "join pasiens as ps on ps.id = px.pasien_id ";
		$query .= "where date(px.tanggal) between '{$mulai}' and '{$akhir}' ";
		$query .= "and px.tenant_id = " . session()->get('tenant_id') . " ";
		$query .= "and dg.diagnosa like '%pneum%' ";
        if (env("DB_CONNECTION") == 'mysql') {
            $query            .= "and TIMESTAMPDIFF(YEAR, ps.tanggal_lahir, px.tanggal)";
        } else {
            $query            .= "and cast(strftime('%Y.%m%d', 'now') - strftime('%Y.%m%d', ps.tanggal_lahir) as int)";
        }
        $query .= " > 5 ";
		$query .= "and ps.sex = 1 ";
        $jumlahIspaPneumonia_diatas_5_tahun_L = DB::select($query)[0]->jumlah;

		$query  = "select count(*) as jumlah ";
		$query .= "from periksas as px ";
		$query .= "join diagnosas as dg on dg.id = px.diagnosa_id ";
		$query .= "join pasiens as ps on ps.id = px.pasien_id ";
		$query .= "where date(px.tanggal) between '{$mulai}' and '{$akhir}' ";
		$query .= "and px.tenant_id = " . session()->get('tenant_id') . " ";
		$query .= "and dg.icd10_id = 'J06' ";
        if (env("DB_CONNECTION") == 'mysql') {
            $query            .= "and TIMESTAMPDIFF(YEAR, ps.tanggal_lahir, px.tanggal)";
        } else {
            $query            .= "and cast(strftime('%Y.%m%d', 'now') - strftime('%Y.%m%d', ps.tanggal_lahir) as int)";
        }
        $query .= " = 0 ";
		$query .= "and ps.sex = 0 ";
        $jumlahIspa_0_1_P = DB::select($query)[0]->jumlah;

		$query  = "select count(*) as jumlah ";
		$query .= "from periksas as px ";
		$query .= "join diagnosas as dg on dg.id = px.diagnosa_id ";
		$query .= "join pasiens as ps on ps.id = px.pasien_id ";
		$query .= "where date(px.tanggal) between '{$mulai}' and '{$akhir}' ";
		$query .= "and px.tenant_id = " . session()->get('tenant_id') . " ";
		$query .= "and dg.icd10_id = 'J06' ";
        if (env("DB_CONNECTION") == 'mysql') {
            $query            .= "and TIMESTAMPDIFF(YEAR, ps.tanggal_lahir, px.tanggal)";
        } else {
            $query            .= "and cast(strftime('%Y.%m%d', 'now') - strftime('%Y.%m%d', ps.tanggal_lahir) as int)";
        }
        $query .= " between 1 and 5 ";
		$query .= "and ps.sex = 0 ";
        $jumlahIspa_1_5_P = DB::select($query)[0]->jumlah;

		$query  = "select count(*) as jumlah ";
		$query .= "from periksas as px ";
		$query .= "join diagnosas as dg on dg.id = px.diagnosa_id ";
		$query .= "join pasiens as ps on ps.id = px.pasien_id ";
		$query .= "where date(px.tanggal) between '{$mulai}' and '{$akhir}' ";
		$query .= "and px.tenant_id = " . session()->get('tenant_id') . " ";
		$query .= "and dg.diagnosa like '%pneum%' ";
        if (env("DB_CONNECTION") == 'mysql') {
            $query            .= "and TIMESTAMPDIFF(YEAR, ps.tanggal_lahir, px.tanggal)";
        } else {
            $query            .= "and cast(strftime('%Y.%m%d', 'now') - strftime('%Y.%m%d', ps.tanggal_lahir) as int)";
        }
        $query .= " = 0 ";
		$query .= "and ps.sex = 0 ";
        $jumlahPneumonia_0_1_P = DB::select($query)[0]->jumlah;

		$query  = "select count(*) as jumlah ";
		$query .= "from periksas as px ";
		$query .= "join diagnosas as dg on dg.id = px.diagnosa_id ";
		$query .= "join pasiens as ps on ps.id = px.pasien_id ";
		$query .= "where date(px.tanggal) between '{$mulai}' and '{$akhir}' ";
		$query .= "and px.tenant_id = " . session()->get('tenant_id') . " ";
		$query .= "and dg.diagnosa like '%pneum%' ";
        if (env("DB_CONNECTION") == 'mysql') {
            $query            .= "and TIMESTAMPDIFF(YEAR, ps.tanggal_lahir, px.tanggal)";
        } else {
            $query            .= "and cast(strftime('%Y.%m%d', 'now') - strftime('%Y.%m%d', ps.tanggal_lahir) as int)";
        }
        $query .= " between 1 and 5 ";
		$query .= "and ps.sex = 0 ";
        $jumlahPneumonia_1_5_P = DB::select($query)[0]->jumlah;

		$query  = "select count(*) as jumlah ";
		$query .= "from periksas as px ";
		$query .= "join diagnosas as dg on dg.id = px.diagnosa_id ";
		$query .= "join pasiens as ps on ps.id = px.pasien_id ";
		$query .= "where date(px.tanggal) between '{$mulai}' and '{$akhir}' ";
		$query .= "and px.tenant_id = " . session()->get('tenant_id') . " ";
		$query .= "and (";
		$query .= "dg.icd10_id like 'a00%' ";
		$query .= "or dg.icd10_id like 'a04%' ";
		$query .= "or dg.icd10_id like 'a06%' ";
		$query .= "or dg.icd10_id like 'a08%' ";
		$query .= "or dg.icd10_id like 'a09%'";
		$query .= ") ";
        if (env("DB_CONNECTION") == 'mysql') {
            $query            .= "and TIMESTAMPDIFF(YEAR, ps.tanggal_lahir, px.tanggal)";
        } else {
            $query            .= "and cast(strftime('%Y.%m%d', 'now') - strftime('%Y.%m%d', ps.tanggal_lahir) as int)";
        }
        $query .= " = 0 ";
		$query .= "and ps.sex = 0 ";
        $jumlahDiare_0_1_P = DB::select($query)[0]->jumlah;

		$query  = "select count(*) as jumlah ";
		$query .= "from periksas as px ";
		$query .= "join diagnosas as dg on dg.id = px.diagnosa_id ";
		$query .= "join pasiens as ps on ps.id = px.pasien_id ";
		$query .= "where date(px.tanggal) between '{$mulai}' and '{$akhir}' ";
		$query .= "and px.tenant_id = " . session()->get('tenant_id') . " ";
		$query .= "and (";
		$query .= "dg.icd10_id like 'a00%' ";
		$query .= "or dg.icd10_id like 'a04%' ";
		$query .= "or dg.icd10_id like 'a06%' ";
		$query .= "or dg.icd10_id like 'a08%' ";
		$query .= "or dg.icd10_id like 'a09%'";
		$query .= ") ";
        if (env("DB_CONNECTION") == 'mysql') {
            $query            .= "and TIMESTAMPDIFF(YEAR, ps.tanggal_lahir, px.tanggal)";
        } else {
            $query            .= "and cast(strftime('%Y.%m%d', 'now') - strftime('%Y.%m%d', ps.tanggal_lahir) as int)";
        }
        $query .= " between 1 and 5 ";
		$query .= "and ps.sex = 0 ";
        $jumlahDiare_1_5_P = DB::select($query)[0]->jumlah;


		$query  = "select count(*) as jumlah ";
		$query .= "from periksas as px ";
		$query .= "join diagnosas as dg on dg.id = px.diagnosa_id ";
		$query .= "join pasiens as ps on ps.id = px.pasien_id ";
		$query .= "where date(px.tanggal) between '{$mulai}' and '{$akhir}' ";
		$query .= "and px.tenant_id = " . session()->get('tenant_id') . " ";
		$query .= "and dg.icd10_id = 'J06' ";
        if (env("DB_CONNECTION") == 'mysql') {
            $query            .= "and TIMESTAMPDIFF(YEAR, ps.tanggal_lahir, px.tanggal)";
        } else {
            $query            .= "and cast(strftime('%Y.%m%d', 'now') - strftime('%Y.%m%d', ps.tanggal_lahir) as int)";
        }
        $query .= " > 5 ";
		$query .= "and ps.sex = 0 ";
        $jumlahIspaBukanPneumonia_diatas_5_tahun_P = DB::select($query)[0]->jumlah;

		$query  = "select count(*) as jumlah ";
		$query .= "from periksas as px ";
		$query .= "join diagnosas as dg on dg.id = px.diagnosa_id ";
		$query .= "join pasiens as ps on ps.id = px.pasien_id ";
		$query .= "where date(px.tanggal) between '{$mulai}' and '{$akhir}' ";
		$query .= "and px.tenant_id = " . session()->get('tenant_id') . " ";
		$query .= "and dg.diagnosa like '%pneum%' ";
        if (env("DB_CONNECTION") == 'mysql') {
            $query            .= "and TIMESTAMPDIFF(YEAR, ps.tanggal_lahir, px.tanggal)";
        } else {
            $query            .= "and cast(strftime('%Y.%m%d', 'now') - strftime('%Y.%m%d', ps.tanggal_lahir) as int)";
        }
        $query .= " > 5 ";
		$query .= "and ps.sex = 0 ";
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

		$query = "select count(*) as jumlah ";
		$query .= "from periksas as px ";
		$query .= "join diagnosas as dg on dg.id = px.diagnosa_id ";
		$query .= "join pasiens as ps on ps.id = px.pasien_id ";
		$query .= "where date(px.tanggal) between '{$mulai}' and '{$akhir}' ";
		$query .= "and (";
		$query .= "dg.icd10_id like 'a00%' ";
		$query .= "or dg.icd10_id like 'a04%' ";
		$query .= "or dg.icd10_id like 'a06%' ";
		$query .= "or dg.icd10_id like 'a08%' ";
		$query .= "or dg.icd10_id like 'a09%'";
		$query .= ") ";
		$query .= "and px.tenant_id = " . session()->get('tenant_id') . " ";
        if (env("DB_CONNECTION") == 'mysql') {
            $query .= "and TIMESTAMPDIFF(MONTH, ps.tanggal_lahir, px.tanggal)";
        } else {
            $query .= "and cast((julianday(px.tanggal)-julianday(ps.tanggal_lahir))/(365/12) as int)";
        }

        $query .= " between 0 and 5 ";
		$query .= "and ps.sex = 1 ";
        $jumlahDiare_0_5_L = DB::select($query)[0]->jumlah;

		$query = "select count(*) as jumlah ";
		$query .= "from periksas as px ";
		$query .= "join diagnosas as dg on dg.id = px.diagnosa_id ";
		$query .= "join pasiens as ps on ps.id = px.pasien_id ";
		$query .= "where date(px.tanggal) between '{$mulai}' and '{$akhir}' ";
		$query .= "and (";
		$query .= "dg.icd10_id like 'a00%' ";
		$query .= "or dg.icd10_id like 'a04%' ";
		$query .= "or dg.icd10_id like 'a06%' ";
		$query .= "or dg.icd10_id like 'a08%' ";
		$query .= "or dg.icd10_id like 'a09%'";
		$query .= ") "; 
		$query .= "and px.tenant_id = " . session()->get('tenant_id') . " ";
        if (env("DB_CONNECTION") == 'mysql') {
            $query .= "and TIMESTAMPDIFF(MONTH, ps.tanggal_lahir, px.tanggal)";
        } else {
            $query .= "and cast((julianday(px.tanggal)-julianday(ps.tanggal_lahir))/(365/12) as int)";
        }
        $query .= " between 0 and 5 ";
		$query .= "and ps.sex = 0 ";
        $jumlahDiare_0_5_P = DB::select($query)[0]->jumlah;

		$query = "select count(*) as jumlah ";
		$query .= "from periksas as px ";
		$query .= "join diagnosas as dg on dg.id = px.diagnosa_id ";
		$query .= "join pasiens as ps on ps.id = px.pasien_id ";
		$query .= "where date(px.tanggal) between '{$mulai}' and '{$akhir}' ";
		$query .= "and (";
		$query .= "dg.icd10_id like 'a00%' ";
		$query .= "or dg.icd10_id like 'a04%' ";
		$query .= "or dg.icd10_id like 'a06%' ";
		$query .= "or dg.icd10_id like 'a08%' ";
		$query .= "or dg.icd10_id like 'a09%') ";
		$query .= "and px.tenant_id = " . session()->get('tenant_id') . " ";
        if (env("DB_CONNECTION") == 'mysql') {
            $query .= "and TIMESTAMPDIFF(MONTH, ps.tanggal_lahir, px.tanggal)";
        } else {
            $query .= "and cast((julianday(px.tanggal)-julianday(ps.tanggal_lahir))/(365/12) as int)";
        }
        $query .= " between 6 and 11 and ps.sex = 1 ";
        $jumlahDiare_6_12_L = DB::select($query)[0]->jumlah;

		$query = "select count(*) as jumlah ";
		$query .= "from periksas as px ";
		$query .= "join diagnosas as dg on dg.id = px.diagnosa_id ";
		$query .= "join pasiens as ps on ps.id = px.pasien_id ";
		$query .= "where date(px.tanggal) between '{$mulai}' and '{$akhir}' ";
		$query .= "and (";
		$query .= "dg.icd10_id like 'a00%' ";
		$query .= "or dg.icd10_id like 'a04%' ";
		$query .= "or dg.icd10_id like 'a06%' ";
		$query .= "or dg.icd10_id like 'a08%' ";
		$query .= "or dg.icd10_id like 'a09%') ";
		$query .= "and px.tenant_id = " . session()->get('tenant_id') . " ";
        if (env("DB_CONNECTION") == 'mysql') {
            $query .= "and TIMESTAMPDIFF(MONTH, ps.tanggal_lahir, px.tanggal)";
        } else {
            $query .= "and cast((julianday(px.tanggal)-julianday(ps.tanggal_lahir))/(365/12) as int)";
        }
        $query .= " between 6 and 11 ";
		$query .= "and ps.sex = 0 ";
        $jumlahDiare_6_12_P = DB::select($query)[0]->jumlah;
         
		$query = "select count(*) as jumlah ";
		$query .= "from periksas as px ";
		$query .= "join diagnosas as dg on dg.id = px.diagnosa_id ";
		$query .= "join pasiens as ps on ps.id = px.pasien_id ";
		$query .= "where date(px.tanggal) between '{$mulai}' and '{$akhir}' ";
		$query .= "and (";
		$query .= "dg.icd10_id like 'a00%' ";
		$query .= "or dg.icd10_id like 'a04%' ";
		$query .= "or dg.icd10_id like 'a06%' ";
		$query .= "or dg.icd10_id like 'a08%' ";
		$query .= "or dg.icd10_id like 'a09%') ";
		$query .= "and px.tenant_id = " . session()->get('tenant_id') . " ";
        if (env("DB_CONNECTION") == 'mysql') {
            $query            .= "and TIMESTAMPDIFF(YEAR, ps.tanggal_lahir, px.tanggal)";
        } else {
            $query            .= "and cast(strftime('%Y.%m%d', 'now') - strftime('%Y.%m%d', ps.tanggal_lahir) as int)";
        }
        $query .= " between 1 and 4 ";
		$query .= "and ps.sex = 1 ";
        $jumlahDiare_1_4_L = DB::select($query)[0]->jumlah;

		$query = "select count(*) as jumlah ";
		$query .= "from periksas as px ";
		$query .= "join diagnosas as dg on dg.id = px.diagnosa_id ";
		$query .= "join pasiens as ps on ps.id = px.pasien_id ";
		$query .= "where date(px.tanggal) between '{$mulai}' and '{$akhir}' ";
		$query .= "and (";
		$query .= "dg.icd10_id like 'a00%' ";
		$query .= "or dg.icd10_id like 'a04%' ";
		$query .= "or dg.icd10_id like 'a06%' ";
		$query .= "or dg.icd10_id like 'a08%' ";
		$query .= "or dg.icd10_id like 'a09%') ";
		$query .= "and px.tenant_id = " . session()->get('tenant_id') . " ";
        if (env("DB_CONNECTION") == 'mysql') {
            $query            .= "and TIMESTAMPDIFF(YEAR, ps.tanggal_lahir, px.tanggal)";
        } else {
            $query            .= "and cast(strftime('%Y.%m%d', 'now') - strftime('%Y.%m%d', ps.tanggal_lahir) as int)";
        }
        $query .= " between 1 and 4 ";
		$query .= "and ps.sex = 0 ";
        $jumlahDiare_1_4_P = DB::select($query)[0]->jumlah;
         
		$query = "select count(*) as jumlah ";
		$query .= "from periksas as px ";
		$query .= "join diagnosas as dg on dg.id = px.diagnosa_id ";
		$query .= "join pasiens as ps on ps.id = px.pasien_id ";
		$query .= "where date(px.tanggal) between '{$mulai}' and '{$akhir}' ";
		$query .= "and (";
		$query .= "dg.icd10_id like 'a00%' ";
		$query .= "or dg.icd10_id like 'a04%' ";
		$query .= "or dg.icd10_id like 'a06%' ";
		$query .= "or dg.icd10_id like 'a08%' ";
		$query .= "or dg.icd10_id like 'a09%') ";
		$query .= "and px.tenant_id = " . session()->get('tenant_id') . " ";
        if (env("DB_CONNECTION") == 'mysql') {
            $query            .= "and TIMESTAMPDIFF(YEAR, ps.tanggal_lahir, px.tanggal)";
        } else {
            $query            .= "and cast(strftime('%Y.%m%d', 'now') - strftime('%Y.%m%d', ps.tanggal_lahir) as int)";
        }
        $query .= " between 5 and 9 ";
		$query .= "and ps.sex = 1 ";
        $jumlahDiare_5_9_L = DB::select($query)[0]->jumlah;
         
		$query = "select count(*) as jumlah ";
		$query .= "from periksas as px ";
		$query .= "join diagnosas as dg on dg.id = px.diagnosa_id ";
		$query .= "join pasiens as ps on ps.id = px.pasien_id ";
		$query .= "where date(px.tanggal) between '{$mulai}' and '{$akhir}' ";
		$query .= "and (";
		$query .= "dg.icd10_id like 'a00%' ";
		$query .= "or dg.icd10_id like 'a04%' ";
		$query .= "or dg.icd10_id like 'a06%' ";
		$query .= "or dg.icd10_id like 'a08%' ";
		$query .= "or dg.icd10_id like 'a09%') ";
		$query .= "and px.tenant_id = " . session()->get('tenant_id') . " ";
        if (env("DB_CONNECTION") == 'mysql') {
            $query            .= "and TIMESTAMPDIFF(YEAR, ps.tanggal_lahir, px.tanggal)";
        } else {
            $query            .= "and cast(strftime('%Y.%m%d', 'now') - strftime('%Y.%m%d', ps.tanggal_lahir) as int)";
        }
        $query .= " between 5 and 9 ";
		$query .= "and ps.sex = 0 ";
        $jumlahDiare_5_9_P = DB::select($query)[0]->jumlah;

		$query = "select count(*) as jumlah ";
		$query .= "from periksas as px ";
		$query .= "join diagnosas as dg on dg.id = px.diagnosa_id ";
		$query .= "join pasiens as ps on ps.id = px.pasien_id ";
		$query .= "where date(px.tanggal) between '{$mulai}' and '{$akhir}' ";
		$query .= "and (";
		$query .= "dg.icd10_id like 'a00%' ";
		$query .= "or dg.icd10_id like 'a04%' ";
		$query .= "or dg.icd10_id like 'a06%' ";
		$query .= "or dg.icd10_id like 'a08%' ";
		$query .= "or dg.icd10_id like 'a09%') ";
		$query .= "and px.tenant_id = " . session()->get('tenant_id') . " ";
        if (env("DB_CONNECTION") == 'mysql') {
            $query            .= "and TIMESTAMPDIFF(YEAR, ps.tanggal_lahir, px.tanggal)";
        } else {
            $query            .= "and cast(strftime('%Y.%m%d', 'now') - strftime('%Y.%m%d', ps.tanggal_lahir) as int)";
        }
        $query .= " between 10 and 14 ";
		$query .= "and ps.sex = 1 ";
        $jumlahDiare_10_14_L = DB::select($query)[0]->jumlah;

		$query = "select count(*) as jumlah ";
		$query .= "from periksas as px ";
		$query .= "join diagnosas as dg on dg.id = px.diagnosa_id ";
		$query .= "join pasiens as ps on ps.id = px.pasien_id ";
		$query .= "where date(px.tanggal) between '{$mulai}' and '{$akhir}' ";
		$query .= "and (";
		$query .= "dg.icd10_id like 'a00%' ";
		$query .= "or dg.icd10_id like 'a04%' ";
		$query .= "or dg.icd10_id like 'a06%' ";
		$query .= "or dg.icd10_id like 'a08%' ";
		$query .= "or dg.icd10_id like 'a09%') ";
		$query .= "and px.tenant_id = " . session()->get('tenant_id') . " ";
        if (env("DB_CONNECTION") == 'mysql') {
            $query            .= "and TIMESTAMPDIFF(YEAR, ps.tanggal_lahir, px.tanggal)";
        } else {
            $query            .= "and cast(strftime('%Y.%m%d', 'now') - strftime('%Y.%m%d', ps.tanggal_lahir) as int)";
        }
        $query .= " between 10 and 14 ";
		$query .= "and ps.sex = 0 ";
        $jumlahDiare_10_14_P = DB::select($query)[0]->jumlah;
         
		$query = "select count(*) as jumlah ";
		$query .= "from periksas as px ";
		$query .= "join diagnosas as dg on dg.id = px.diagnosa_id ";
		$query .= "join pasiens as ps on ps.id = px.pasien_id ";
		$query .= "where date(px.tanggal) between '{$mulai}' and '{$akhir}' ";
		$query .= "and (";
		$query .= "dg.icd10_id like 'a00%' ";
		$query .= "or dg.icd10_id like 'a04%' ";
		$query .= "or dg.icd10_id like 'a06%' ";
		$query .= "or dg.icd10_id like 'a08%' ";
		$query .= "or dg.icd10_id like 'a09%') ";
		$query .= "and px.tenant_id = " . session()->get('tenant_id') . " ";
        if (env("DB_CONNECTION") == 'mysql') {
            $query            .= "and TIMESTAMPDIFF(YEAR, ps.tanggal_lahir, px.tanggal)";
        } else {
            $query            .= "and cast(strftime('%Y.%m%d', 'now') - strftime('%Y.%m%d', ps.tanggal_lahir) as int)";
        }
        $query .= " between 15 and 19 ";
		$query .= "and ps.sex = 1 ";
        $jumlahDiare_15_19_L = DB::select($query)[0]->jumlah;

		$query = "select count(*) as jumlah ";
		$query .= "from periksas as px ";
		$query .= "join diagnosas as dg on dg.id = px.diagnosa_id ";
		$query .= "join pasiens as ps on ps.id = px.pasien_id ";
		$query .= "where date(px.tanggal) between '{$mulai}' and '{$akhir}' ";
		$query .= "and (";
		$query .= "dg.icd10_id like 'a00%' ";
		$query .= "or dg.icd10_id like 'a04%' ";
		$query .= "or dg.icd10_id like 'a06%' ";
		$query .= "or dg.icd10_id like 'a08%' ";
		$query .= "or dg.icd10_id like 'a09%') ";
		$query .= "and px.tenant_id = " . session()->get('tenant_id') . " ";
        if (env("DB_CONNECTION") == 'mysql') {
            $query            .= "and TIMESTAMPDIFF(YEAR, ps.tanggal_lahir, px.tanggal)";
        } else {
            $query            .= "and cast(strftime('%Y.%m%d', 'now') - strftime('%Y.%m%d', ps.tanggal_lahir) as int)";
        }
        $query .= " between 15 and 19 ";
		$query .= "and ps.sex = 0 ";
        $jumlahDiare_15_19_P = DB::select($query)[0]->jumlah;

		$query = "select count(*) as jumlah ";
		$query .= "from periksas as px ";
		$query .= "join diagnosas as dg on dg.id = px.diagnosa_id ";
		$query .= "join pasiens as ps on ps.id = px.pasien_id ";
		$query .= "where date(px.tanggal) between '{$mulai}' and '{$akhir}' ";
		$query .= "and (";
		$query .= "dg.icd10_id like 'a00%' ";
		$query .= "or dg.icd10_id like 'a04%' ";
		$query .= "or dg.icd10_id like 'a06%' ";
		$query .= "or dg.icd10_id like 'a08%' ";
		$query .= "or dg.icd10_id like 'a09%') ";
		$query .= "and px.tenant_id = " . session()->get('tenant_id') . " ";
        if (env("DB_CONNECTION") == 'mysql') {
            $query            .= "and TIMESTAMPDIFF(YEAR, ps.tanggal_lahir, px.tanggal)";
        } else {
            $query            .= "and cast(strftime('%Y.%m%d', 'now') - strftime('%Y.%m%d', ps.tanggal_lahir) as int)";
        }
        $query .= " > 20 ";
		$query .= "and ps.sex = 1 ";
        $jumlahDiare_20_L = DB::select($query)[0]->jumlah;

		$query = "select count(*) as jumlah ";
		$query .= "from periksas as px ";
		$query .= "join diagnosas as dg on dg.id = px.diagnosa_id ";
		$query .= "join pasiens as ps on ps.id = px.pasien_id ";
		$query .= "where date(px.tanggal) between '{$mulai}' and '{$akhir}' ";
		$query .= "and (";
		$query .= "dg.icd10_id like 'a00%' ";
		$query .= "or dg.icd10_id like 'a04%' ";
		$query .= "or dg.icd10_id like 'a06%' ";
		$query .= "or dg.icd10_id like 'a08%' ";
		$query .= "or dg.icd10_id like 'a09%') ";
		$query .= "and px.tenant_id = " . session()->get('tenant_id') . " ";
        if (env("DB_CONNECTION") == 'mysql') {
            $query            .= "and TIMESTAMPDIFF(YEAR, ps.tanggal_lahir, px.tanggal)";
        } else {
            $query            .= "and cast(strftime('%Y.%m%d', 'now') - strftime('%Y.%m%d', ps.tanggal_lahir) as int)";
        }
        $query .= " > 20 ";
		$query .= "and ps.sex = 0 ";
        $jumlahDiare_20_P = DB::select($query)[0]->jumlah;

		$query = "select count(*) as jumlah ";
		$query .= "from periksas as px ";
		$query .= "join diagnosas as dg on dg.id = px.diagnosa_id ";
		$query .= "join pasiens as ps on ps.id = px.pasien_id ";
		$query .= "where date(px.tanggal) between '{$mulai}' and '{$akhir}' ";
		$query .= "and px.tenant_id = " . session()->get('tenant_id') . " ";
		$query .= "and (";
		$query .= "dg.icd10_id like 'a00%' ";
		$query .= "or dg.icd10_id like 'a04%' ";
		$query .= "or dg.icd10_id like 'a06%' ";
		$query .= "or dg.icd10_id like 'a08%' ";
		$query .= "or dg.icd10_id like 'a09%') ";
        $jumlahDiare = DB::select($query)[0]->jumlah;

		$query = "select count(*) as jumlah ";
		$query .= "from terapis as tp ";
		$query .= "join periksas as px on px.id = tp.periksa_id ";
		$query .= "join mereks as mr on mr.id = tp.merek_id ";
		$query .= "join raks as rk on rk.id = mr.rak_id ";
		$query .= "join formulas as fr on fr.id=rk.formula_id ";
		$query .= "where fr.id='150811020' ";
		$query .= "and tp.tenant_id = " . session()->get('tenant_id') . " ";
		$query .= "and date(px.tanggal) between '{$mulai}' and '{$akhir}' ";
        $jumlahOralit = DB::select($query)[0]->jumlah;


		$query = "select count(*) as jumlah ";
		$query .= "from terapis as tp ";
		$query .= "join periksas as px on px.id = tp.periksa_id ";
		$query .= "join mereks as mr on mr.id = tp.merek_id ";
		$query .= "join raks as rk on rk.id = mr.rak_id ";
		$query .= "join formulas as fr on fr.id=rk.formula_id ";
		$query .= "join pasiens as ps on ps.id = px.pasien_id ";
		$query .= "where fr.id='150802006' ";
		$query .= "and tp.tenant_id = " . session()->get('tenant_id') . " ";
		$query .= "and date(px.tanggal) between '{$mulai}' and '{$akhir}' ";
        if (env("DB_CONNECTION") == 'mysql') {
            $query .= "and TIMESTAMPDIFF(MONTH, ps.tanggal_lahir, px.tanggal)";
        } else {
            $query .= "and cast((julianday(px.tanggal)-julianday(ps.tanggal_lahir))/(365/12) as int)";
        }
        $query .= " between 0 and 5 ";
        $jumlahZink_0_5 = DB::select($query)[0]->jumlah;

		$query = "select count(*) as jumlah ";
		$query .= "from terapis as tp ";
		$query .= "join periksas as px on px.id = tp.periksa_id ";
		$query .= "join mereks as mr on mr.id = tp.merek_id ";
		$query .= "join raks as rk on rk.id = mr.rak_id ";
		$query .= "join formulas as fr on fr.id=rk.formula_id ";
		$query .= "join pasiens as ps on ps.id = px.pasien_id ";
		$query .= "where fr.id='150802006' ";
		$query .= "and tp.tenant_id = " . session()->get('tenant_id') . " ";
		$query .= "and date(px.tanggal) between '{$mulai}' and '{$akhir}' ";
        if (env("DB_CONNECTION") == 'mysql') {
            $query .= "and TIMESTAMPDIFF(MONTH, ps.tanggal_lahir, px.tanggal)";
        } else {
            $query .= "and cast((julianday(px.tanggal)-julianday(ps.tanggal_lahir))/(365/12) as int)";
        }
        $query .= " between 6 and 11 ";
        $jumlahZink_6_11 = DB::select($query)[0]->jumlah;

		$query = "select count(*) as jumlah ";
		$query .= "from terapis as tp ";
		$query .= "join periksas as px on px.id = tp.periksa_id ";
		$query .= "join mereks as mr on mr.id = tp.merek_id ";
		$query .= "join raks as rk on rk.id = mr.rak_id ";
		$query .= "join formulas as fr on fr.id=rk.formula_id ";
		$query .= "join pasiens as ps on ps.id = px.pasien_id ";
		$query .= "where fr.id='150802006' ";
		$query .= "and tp.tenant_id = " . session()->get('tenant_id') . " ";
		$query .= "and date(px.tanggal) between '{$mulai}' and '{$akhir}' ";
        if (env("DB_CONNECTION") == 'mysql') {
            $query            .= "and TIMESTAMPDIFF(YEAR, ps.tanggal_lahir, px.tanggal)";
        } else {
            $query            .= "and cast(strftime('%Y.%m%d', 'now') - strftime('%Y.%m%d', ps.tanggal_lahir) as int)";
        }
        $query .= " between 1 and 4 ";
        $jumlahZink_1_4 = DB::select($query)[0]->jumlah;

		$query = "select count(*) as jumlah ";
		$query .= "from terapis as tp ";
		$query .= "join periksas as px on px.id = tp.periksa_id ";
		$query .= "join mereks as mr on mr.id = tp.merek_id ";
		$query .= "join raks as rk on rk.id = mr.rak_id ";
		$query .= "join formulas as fr on fr.id=rk.formula_id ";
		$query .= "join pasiens as ps on ps.id = px.pasien_id ";
		$query .= "where fr.id='150811020' and date(px.tanggal) between '{$mulai}' and '{$akhir}' ";
		$query .= "and tp.tenant_id = " . session()->get('tenant_id') . " ";
        if (env("DB_CONNECTION") == 'mysql') {
            $query            .= "and TIMESTAMPDIFF(YEAR, ps.tanggal_lahir, px.tanggal)";
        } else {
            $query            .= "and cast(strftime('%Y.%m%d', 'now') - strftime('%Y.%m%d', ps.tanggal_lahir) as int)";
        }
        $query .= " > 4 ";
        $jumlahOralit_lebih_dari_5 = DB::select($query)[0]->jumlah;

		$query = "select count(*) as jumlah ";
		$query .= "from terapis as tp ";
		$query .= "join periksas as px on px.id = tp.periksa_id ";
		$query .= "join mereks as mr on mr.id = tp.merek_id ";
		$query .= "join raks as rk on rk.id = mr.rak_id ";
		$query .= "join formulas as fr on fr.id=rk.formula_id ";
		$query .= "join pasiens as ps on ps.id = px.pasien_id ";
		$query .= "where fr.id='150811020' and date(px.tanggal) between '{$mulai}' and '{$akhir}' ";
		$query .= "and tp.tenant_id = " . session()->get('tenant_id') . " ";
        if (env("DB_CONNECTION") == 'mysql') {
            $query            .= "and TIMESTAMPDIFF(YEAR, ps.tanggal_lahir, px.tanggal)";
        } else {
            $query            .= "and cast(strftime('%Y.%m%d', 'now') - strftime('%Y.%m%d', ps.tanggal_lahir) as int)";
        }
        $query .= " < 5 ";
        $jumlahOralit_kurang_dari_5 = DB::select($query)[0]->jumlah;

		$query = "select count(*) as jumlah ";
		$query .= "from terapis as tp ";
		$query .= "join periksas as px on px.id = tp.periksa_id ";
		$query .= "join mereks as mr on mr.id = tp.merek_id ";
		$query .= "join raks as rk on rk.id = mr.rak_id ";
		$query .= "join formulas as fr on fr.id=rk.formula_id ";
		$query .= "join diagnosas as dg on dg.id=px.diagnosa_id ";
		$query .= "join pasiens as ps on ps.id = px.pasien_id ";
		$query .= "where fr.id='150802006' and date(px.tanggal) between '{$mulai}' and '{$akhir}' ";
		$query .= "and tp.tenant_id = " . session()->get('tenant_id') . " ";
        if (env("DB_CONNECTION") == 'mysql') {
            $query .= "and TIMESTAMPDIFF(MONTH, ps.tanggal_lahir, px.tanggal)";
        } else {
            $query .= "and cast((julianday(px.tanggal)-julianday(ps.tanggal_lahir))/(365/12) as int)";
        }
        $query .= " between 0 and 5 ";
		$query .= "and (";
		$query .= "dg.icd10_id like 'a00%' ";
		$query .= "or dg.icd10_id like 'a04%' ";
		$query .= "or dg.icd10_id like 'a06%' ";
		$query .= "or dg.icd10_id like 'a08%' ";
		$query .= "or dg.icd10_id like 'a09%') ";
        $jumlahZink_0_5_diare = DB::select($query)[0]->jumlah;

		$query = "select count(*) as jumlah ";
		$query .= "from terapis as tp ";
		$query .= "join periksas as px on px.id = tp.periksa_id ";
		$query .= "join mereks as mr on mr.id = tp.merek_id ";
		$query .= "join raks as rk on rk.id = mr.rak_id ";
		$query .= "join formulas as fr on fr.id=rk.formula_id ";
		$query .= "join diagnosas as dg on dg.id=px.diagnosa_id ";
		$query .= "join pasiens as ps on ps.id=px.pasien_id ";
		$query .= "where fr.id='150802006' and date(px.tanggal) between '{$mulai}' and '{$akhir}' ";
		$query .= "and tp.tenant_id = " . session()->get('tenant_id') . " ";
        if (env("DB_CONNECTION") == 'mysql') {
            $query .= "and TIMESTAMPDIFF(MONTH, ps.tanggal_lahir, px.tanggal)";
        } else {
            $query .= "and cast((julianday(px.tanggal)-julianday(ps.tanggal_lahir))/(365/12) as int)";
        }
        $query .= " between 6 and 11 ";
		$query .= "and (";
		$query .= "dg.icd10_id like 'a00%' ";
		$query .= "or dg.icd10_id like 'a04%' ";
		$query .= "or dg.icd10_id like 'a06%' ";
		$query .= "or dg.icd10_id like 'a08%' ";
		$query .= "or dg.icd10_id like 'a09%')  ";
        $jumlahZink_6_11_diare = DB::select($query)[0]->jumlah;

		$query = "select count(*) as jumlah ";
		$query .= "from terapis as tp ";
		$query .= "join periksas as px on px.id = tp.periksa_id ";
		$query .= "join mereks as mr on mr.id = tp.merek_id ";
		$query .= "join raks as rk on rk.id = mr.rak_id ";
		$query .= "join formulas as fr on fr.id=rk.formula_id ";
		$query .= "join diagnosas as dg on dg.id=px.diagnosa_id ";
		$query .= "join pasiens as ps on ps.id=px.pasien_id ";
		$query .= "where fr.id='150802006' and date(px.tanggal) between '{$mulai}' and '{$akhir}' ";
		$query .= "and tp.tenant_id = " . session()->get('tenant_id') . " ";
        if (env("DB_CONNECTION") == 'mysql') {
            $query            .= "and TIMESTAMPDIFF(YEAR, ps.tanggal_lahir, px.tanggal)";
        } else {
            $query            .= "and cast(strftime('%Y.%m%d', 'now') - strftime('%Y.%m%d', ps.tanggal_lahir) as int)";
        }
        $query .= " between 1 and 4 ";
		$query .= "and (";
		$query .= "dg.icd10_id like 'a00%' ";
		$query .= "or dg.icd10_id like 'a04%' ";
		$query .= "or dg.icd10_id like 'a06%' ";
		$query .= "or dg.icd10_id like 'a08%' ";
		$query .= "or dg.icd10_id like 'a09%')  ";
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
		$tanggal_awal  = Yoga::datePrep(Input::get('tanggal_awal'));
		$tanggal_akhir = Yoga::datePrep(Input::get('tanggal_akhir'));
		$jam_awal      = Input::get('jam_awal');
		$jam_akhir     = Input::get('jam_akhir');
		$tanggal_awal  = $tanggal_awal . ' ' . $jam_awal;
		$tanggal_akhir = $tanggal_akhir . ' ' . $jam_akhir;
		$jenis_tarifs  = JenisTarif::all();

		$query = "SELECT *, ";
		$query .= "p.id as periksa_id, ";
		$query .= "ps.nama as nama_pasien, ";
		$query .= "asu.nama as nama_asuransi, ";
		$query .= "p.id as periksa_id, ";
		$query .= "po.poli as poli ";
		$query .= "FROM periksas as p ";
		$query .= "JOIN polis as po on po.id = p.poli_id ";
		$query .= "LEFT OUTER JOIN pasiens as ps on ps.id = p.pasien_id ";
		$query .= "LEFT OUTER JOIN asuransis as asu on asu.id = p.asuransi_id ";
		$query .= "where date(p.created_at) between '{$tanggal_awal}' and '{$tanggal_akhir}' ";
		$query .= "and p.tenant_id = " . session()->get('tenant_id') . " ";
		$periksas = DB::select($query);

		$query = "SELECT asu.nama , ";
		$query .= "count(asuransi_id) as jumlah, ";
		$query .= "asu.id as id ";
		$query .= "FROM periksas as p ";
		$query .= "left outer join asuransis as asu on p.asuransi_id = asu.id ";
		$query .= "where date(p.created_at) between '{$tanggal_awal}' and '{$tanggal_akhir}' ";
		$query .= "and p.tenant_id = " . session()->get('tenant_id') . " ";
		$query .= "group by asu.nama"; 
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

		$query = "SELECT count(ks.id) as jumlah ";
		$query .= "FROM kunjungan_sakits as ks ";
		$query .= "join periksas as px on ks.periksa_id = px.id ";
		$query .= "join pasiens as ps on ps.id = px.pasien_id ";
		$query .= "WHERE ks.created_at like '" . date('Y-m') . "%' ";
		$query .= "AND ks.tenant_id = " . session()->get('tenant_id') . " ";
		$query .= "AND ks.pcare_submit = 1 ";
		$query .= "AND px.pasien_id = '" . $id . "' ";

		$countKunjunganSakit = DB::select($query)[0]->jumlah;

		if ($countKunjunganSakit > 0) {
			return $countKunjunganSakit;
		}

		return 0;
		 
	}

	public function dispensingBpjs(){
		$staf_id = Input::get('id');
		$bulanTahun = Yoga::bulanTahun( Input::get('mulai') );

		$query  = "SELECT ";
		$query .= "count(px.id) as jumlah, ";
		$query .= "st.id as staf_id, ";
		$query .= "st.nama as nama_staf ";
		$query .= "FROM periksas as px ";
		$query .= "JOIN asuransis as asu on asu.id = px.asuransi_id ";
		$query .= "JOIN stafs as st on st.id = px.staf_id ";
		$query .= "WHERE st.id like '{$staf_id}'";
		$query .= "and px.tenant_id = " . session()->get('tenant_id') . " ";
		$query .= "AND px.tanggal like '{$bulanTahun}%'";
		$query .= "AND asu.tipe_asuransi_id = 5 ";
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
		$query .= "JOIN asuransis as asu on asu.id = px.asuransi_id ";
		$query .= "JOIN stafs as st on st.id = px.staf_id ";
		$query .= "WHERE asu.tipe_asuransi_id = 5 ";
		$query .= "AND tx.tenant_id = " . session()->get('tenant_id') . " ";
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
		$query .= "AND px.tenant_id = " . session()->get('tenant_id') . " ";
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
		$query .= "AND p.tenant_id = " . session()->get('tenant_id') . " ";
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
		$query .= "po.poli as poli ";
		$query .= "FROM periksas as p LEFT OUTER JOIN pasiens as ps on ps.id = p.pasien_id ";
		$query .= "INNER JOIN polis as po on po.id = p.poli_id ";
		$query .= "LEFT OUTER JOIN asuransis as asu on asu.id = p.asuransi_id ";
		$query .= "where p.tanggal like '{$tanggal}' ";
		$query .= "AND p.tenant_id = " . session()->get('tenant_id') . " ";
		$query .= "AND p.asuransi_id like '{$asuransi_id}' ";
		return  DB::select($query);

	}
	public function polisHarian($periksas){
		$poli_id = [];
		foreach ($periksas as $periksa) {
			$poli_id[] = $periksa->poli_id;
		}
		$polis = array_unique($poli_id, SORT_REGULAR);
		sort( $polis );
		return $polis;
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
		$query .= "AND px.tenant_id = " . session()->get('tenant_id') . " ";
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
		$query .= "AND px.tenant_id = " . session()->get('tenant_id') . " ";
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
		$query .= "AND  ps.id not in( Select pasien_id from periksas as prx join asuransis as asu on asu.id = prx.asuransi_id where asu.tipe_asuransi_id = 5 and prx.created_at like '{$tahunBulan}%' )) ";
		$query .= "AND ps.tenant_id = " . session()->get('tenant_id') . " ";
		$query .= "group by px.pasien_id, ps.alamat ";
		$query .= "order by kali_berobat ";
		$query .= "LIMIT 20 ";
		
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

	public function cariJumlahProlanis($bulanTahun){
		$rppt               = PesertaBpjsPerbulan::where('bulanTahun', 'like', $bulanTahun . '%')->latest()->first();
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
			if (!isset($polis[$prx->poli_id])) {
				$polis[$prx->poli_id] = 1;
			} else {
				$polis[$prx->poli_id]++;
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

			if (!isset($hariinis[ $prx->asuransi_id ]['by_poli'][$prx->poli_id])) {
				$hariinis[ $prx->asuransi_id ]['by_poli'][$prx->poli_id] = 1;
			} else {
				$hariinis[ $prx->asuransi_id ]['by_poli'][$prx->poli_id]++;
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
		$query .= "AND prx.tenant_id = " . session()->get('tenant_id') . " ";
		$query .= "GROUP BY prx.id ";
		$query .= "LIMIT 20 ";
		$data = DB::select($query);
		return $data;
	}
	
}
