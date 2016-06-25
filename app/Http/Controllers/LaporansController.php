<?php

namespace App\Http\Controllers;

use Input;

use App\Http\Requests;
use App\Asuransi;
use App\AntrianPeriksa;
use App\Periksa;
use App\BayarDokter;
use App\TransaksiPeriksa;
use App\PembayaranAsuransi;
use App\Staf;
use App\JurnalUmum;
use App\NotaJual;
use App\Coa;
use App\FakturBelanja;
use App\Terapi;
use App\AntrianPoli;
use Auth;
use App\Classes\Yoga;
use DB;
use App\JenisTarif;
use App\TipeLaporanAdmedika;
use App\TipeLaporanKasir;
use App\Rak;
use App\Pendapatan;

class LaporansController extends Controller
{

	public function __construct()
	 {
	     $this->middleware('super', ['except' => ['index', 'harian','penyakit', 'points', 'rujukankebidanan', 'no_asisten']]);
	 }

	public function index()
	{

		// return Auth::id();

		$asuransis = ['%' => 'SEMUA PEMBAYARAN'] + Asuransi::lists('nama', 'id')->all();
		$antrianperiksa = AntrianPeriksa::all();
		$antriankasir = Periksa::where('lewat_kasir2', '0')->orWhere('lewat_kasir', '0')->get();
		$antrianbelanja = FakturBelanja::where('submit', '0')->count();
		$nursestation = AntrianPoli::all();
		$auth = Auth::user();
		$raklist = Yoga::rakList();
		$hariinis = DB::select("SELECT min(asu.nama) as nama , count(asuransi_id) as jumlah, min(asu.id) as id FROM periksas as p LEFT OUTER JOIN asuransis as asu on p.asuransi_id = asu.id WHERE p.tanggal = '" . date('Y-m-d') . "'  group by asu.nama" );
		$umum = AntrianPeriksa::where('poli', 'umum')->get();
		$kandungan = AntrianPeriksa::where('poli', 'kandungan')->get();
		$gigi = AntrianPeriksa::where('poli', 'gigi')->get();
		$darurat = AntrianPeriksa::where('poli', 'darurat')->get();
		$staf = Yoga::stafList();
		
		$jumlah = 0;

		foreach ($hariinis as $hariini) {
			$jumlah += (int) $hariini->jumlah;
		}
		return view('laporans.index')
			->withAsuransis($asuransis)
			->withAntrianperiksa($antrianperiksa)
			->withAntriankasir($antriankasir)
			->withAntrianbelanja($antrianbelanja)
			->withHariinis($hariinis)
			->withJumlah($jumlah)
			->withUmum($umum)
			->withKandungan($kandungan)
			->withGigi($gigi)
			->withRaklist($raklist)
			->withAuth($auth)
			->withStaf($staf)
			->withDarurat($darurat)
			->withNursestation($nursestation);
	}

	public function harian()
	{
		// return Input::all();
		$tanggal = Yoga::datePrep(Input::get('tanggal'));
		$asuransi_id = Input::get('asuransi_id');
		$jenis_tarifs = JenisTarif::all();
		$periksas = DB::select("SELECT *, p.id as periksa_id, ps.nama as nama_pasien, asu.nama as nama_asuransi, p.id as periksa_id FROM periksas as p LEFT OUTER JOIN pasiens as ps on ps.id = p.pasien_id LEFT OUTER JOIN asuransis as asu on asu.id = p.asuransi_id where p.tanggal like '{$tanggal}' AND p.asuransi_id like '{$asuransi_id}' AND p.lewat_kasir = '1'");
		$hariinis = DB::select("SELECT asu.nama , count(asuransi_id) as jumlah, asu.id as id FROM periksas as p left outer join asuransis as asu on p.asuransi_id = asu.id where p.tanggal = '" . $tanggal . "' AND asu.id like '" . $asuransi_id . "'  group by asu.nama" );

		// return $rincian;
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

		return view('laporans.harian')
			->withPeriksas($periksas)
			->withRincian($rincian)
			->withTanggal($tanggal)
			->withJenis_tarifs($jenis_tarifs)
			->withPiutangjumlah($piutangJumlah)
			->withHariinis($hariinis)
			->withTunaijumlah($tunaiJumlah);
	}

	public function haridet()
	{
		// return Input::all();
		$tanggal = Yoga::datePrep(Input::get('tanggal'));
		$asuransi_id = Input::get('asuransi_id');
		$jenis_tarifs = JenisTarif::all();
		$periksas = DB::select("SELECT *, ps.nama as nama_pasien, asu.nama as nama_asuransi, p.id as periksa_id, d.icd10_id as icd10 FROM periksas as p LEFT OUTER JOIN pasiens as ps on ps.id = p.pasien_id LEFT OUTER JOIN asuransis as asu on asu.id = p.asuransi_id join diagnosas as d on d.id=p.diagnosa_id where p.tanggal like '{$tanggal}' AND p.asuransi_id like '{$asuransi_id}' AND p.lewat_kasir = '1'");
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
			->withJenis_tarifs($jenis_tarifs)
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
		$periksas = DB::select("SELECT *, ps.nama as nama_pasien, asu.nama as nama_asuransi, p.id as periksa_id, p.transaksi as transaksi FROM periksas as p LEFT OUTER JOIN pasiens as ps on ps.id = p.pasien_id LEFT OUTER JOIN asuransis as asu on asu.id = p.asuransi_id where p.tanggal like '{$tanggal}' AND p.asuransi_id like '{$asuransi_id}' AND p.lewat_kasir = '1'");
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
			->withJenis_tarifs($jenis_tarifs)
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
		$periksa = Periksa::where('tanggal', 'like', $tanggal . '%')->get();
		$rak = Rak::all();
		return view('laporans.bulanan')
			->withRak($rak)
			->withPeriksa($periksa)
			->withTanggal($tanggal)
			->withAsuransi_id($asuransi_id)
			->withTanggall($tanggall)
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
		// $query = "SELECT ";

		return $query;
		$tanggal = DB::select($query);
		$bln = Input::get('bulanTahun');


		$totalTunaiTanggal = 0;
		$totalPiutangTanggal = 0;
		$totalJumlahTanggal = 0;
		foreach ($tanggal as $k => $v) {
			# code...
			$totalTunaiTanggal += $v->tunai;
			$totalPiutangTanggal += $v->piutang;
			$totalJumlahTanggal += $v->jumlah;
		}

		return view('laporans.tanggal', compact('tanggal', 'totalTunaiTanggal', 'totalPiutangTanggal', 'totalJumlahTanggal', 'bln', 'nama_asuransi'));

	}

	public function detbulan()
	{

		$tanggal 		= Yoga::blnPrep(Input::get('bulanTahun'));
		$asuransi_id 	= Input::get('asuransi_id');


		$query = "SELECT icd.diagnosaICD as diagnosaICD, p.tanggal, ps.nama, s.nama as nama_asuransi, p.tunai as tunai, p.piutang as piutang, p.transaksi as transaksi, sum(tr.harga_beli_satuan * tr.jumlah) as modal_obat, p.id as periksa_id FROM terapis as tr join periksas as p on p.id = tr.periksa_id left outer join asuransis as s on s.id = p.asuransi_id left outer join pasiens as ps on ps.id = p.pasien_id join diagnosas as dg on dg.id = p.diagnosa_id join icd10s as icd on icd.id = dg.icd10_id where p.tanggal like '{$tanggal}%' AND p.asuransi_id like '{$asuransi_id}' group by p.id order by modal_obat desc, tunai desc";
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
			->withAsuransi_id($asuransi_id)
			->withNama_asuransi($nama_asuransi)
			->withRincian($rincian);

	}
	public function payment($id)
	{

		// $periksas = Periksa::where('asuransi_id', $id)->where('piutang', '>' , '0')->where('piutang', '>', 'piutang_dibayar')->get(['id', 'tanggal', 'pasien_id', 'asuransi_id', 'piutang', 'piutang_dibayar']);
		$query = "SELECT px.id as id, p.nama as nama, asu.nama as nama_asuransi, asu.id as asuransi_id, px.tanggal as tanggal, px.piutang as piutang, sum( pasu.pembayaran ) as piutang_dibayar, sum( pasu.pembayaran ) as piutang_dibayar_awal from periksas as px join pasiens as p on px.pasien_id = p.id join asuransis as asu on asu.id = px.asuransi_id left join pembayaran_asuransis as pasu on pasu.periksa_id = px.id where px.piutang > 0 and px.asuransi_id = '{$id}' and (pembayaran is null or piutang > pembayaran) group by id;";

		//$query = "SELECT px.id as id, p.nama as nama, asu.nama as nama_asuransi, asu.id as asuransi_id, px.tanggal as tanggal, px.piutang as piutang, px.piutang_dibayar as piutang_dibayar , px.piutang_dibayar as piutang_dibayar_awal, pasu.pembayaran as pembayaran from periksas as px join pasiens as p on px.pasien_id = p.id join asuransis as asu on asu.id = px.asuransi_id left join pembayaran_asuransis as pasu on pasu.periksa_id = px.id where px.piutang > 0 and px.piutang > px.piutang_dibayar and px.asuransi_id = '{$id}';";

		$periksas = DB::select($query);
        foreach ($periksas as $periksa) {
            if ($periksa->piutang_dibayar == null) {
                $periksa->piutang_dibayar = 0;
            }
            if ($periksa->piutang_dibayar_awal == null) {
                $periksa->piutang_dibayar_awal = 0;
            }
        }

		$asuransi = Asuransi::find($id);
        $terima_coa_list = [null => '-pilih-'] + Coa::where('id', 'like', '110%')->lists('coa', 'id')->all();
		// return $periksas[0];
		return view('laporans.payment', compact('periksas','asuransi', 'terima_coa_list'));

	}
	public function paymentpost()
	{
		$biaya = Input::get('biaya');
		$temp = Input::get('temp');
		$array = json_decode($temp, true);
		$id = Input::get('asuransi_id');

		$asuransi = Asuransi::find($id);

		if ($biaya > 0) {
            $nota_jual_id = Yoga::customId('App\NotaJual');
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
				$jurnal->jurnalable_type = 'App\NotaJual';
				$jurnal->coa_id          = 110000; // Kas di tangan
				$jurnal->debit           = 1;
				$jurnal->nilai           = $biaya;
				$jurnal->save();


				$jurnal                  = new JurnalUmum;
				$jurnal->jurnalable_id   = $nota_jual_id;
				$jurnal->jurnalable_type = 'App\NotaJual';
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
			->withTanggal($tanggal);
	}

	public function status()
	{

		$mulai = Yoga::datePrep(Input::get('mulai'));
		$akhir = Yoga::datePrep(Input::get('akhir'));

		$periksas = Periksa::whereRaw("tanggal between '$mulai' and '$akhir'")->paginate(4);
		return view('laporans.status', compact('periksas'));

	}
	public function points()
	{

		$mulai = Input::get('mulai');
		$akhir = Input::get('akhir');

		$mulai = Yoga::nowIfEmptyMulai($mulai);
		$akhir = Yoga::nowIfEmptyAkhir($akhir);

		$query = "SELECT st.nama, count(pn.tekanan_darah) as tekanan_darah, count(pn.suhu) as suhu, count(pn.berat_badan) as berat_badan, count(pn.tinggi_badan) as tinggi_badan FROM points as pn join periksas as px on px.id = pn.periksa_id join stafs as st on st.id = px.asisten_id  where pn.created_at between '{$mulai}' and '{$akhir}' group by nama";


		$points = DB::select($query);

		// return $points;

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
		// $query = "SELECT max(st.nama) as nama, count(px.suhu) as suhu, count(tinggi_badan) as tb, count(berat_badan) as bb, count(tekanan_darah) as tensi FROM points as px left outer join stafs as st on st.id = px.staf_id WHERE px.created_at BETWEEN '{$mulai} 00:00:00' and '{$akhir} 23:59:59' group by nama;";

		// return var_dump($points);

		return view('laporans.pendapatan', compact('pendapatans', 'mulai', 'akhir'));



	}

	public function rujukankebidanan(){
		// return 'oke';
		$mulai = Input::get('mulai');
		$akhir = Input::get('akhir');

		$mulai = Yoga::nowIfEmptyMulai($mulai);
		$akhir = Yoga::nowIfEmptyAkhir($akhir);

		$query = "SELECT ps.nama as nama_pasien, icd.id as icd10_id, ps.tanggal_lahir as tanggal_lahir, icd.diagnosaICD as diagnosa, tj.tujuan_rujuk as tujuan_rujuk, px.tanggal as tanggal, rj.alasan_rujuk as alasan_rujuk  from rujukans as rj join periksas as px on px.id = rj.periksa_id join diagnosas as dg on dg.id=px.diagnosa_id join icd10s as icd on icd.id=dg.icd10_id join tujuan_rujuks as tj on tj.id=rj.tujuan_rujuk_id join pasiens as ps on ps.id=px.pasien_id where rj.tujuan_rujuk_id = '24' and tanggal between '{$mulai} 00:00:00' and '{$akhir} 23:59:59'";
		$rujukans = DB::select($query);

		return view('laporans.rujukankebidanan', compact('rujukans'));
	}
    public function bayardokter(){
		// return 'oke';
		$id = Input::get('id');
        $nama_staf = Staf::find($id)->nama;
		$mulai = Input::get('mulai');
		$akhir = Input::get('akhir');

		$mulai = Yoga::nowIfEmptyMulai($mulai);
		$akhir = Yoga::nowIfEmptyAkhir($akhir);
         
        $query = "select p.tanggal as tanggal, st.nama as nama_staf, ps.id as pasien_id, ps.nama as nama, asu.nama as nama_asuransi, tunai, piutang, nilai  from jurnal_umums as ju join periksas as p on p.id=ju.jurnalable_id join stafs as st on st.id= p.staf_id join pasiens as ps on ps.id=p.pasien_id join asuransis as asu on asu.id=p.asuransi_id where jurnalable_type='App\\\Periksa' and p.staf_id='{$id}' and ju.coa_id=200001 and ( p.tanggal between '{$mulai}' and '{$akhir}' );";
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
        $query = "select px.tanggal as tanggal, st.nama as nama_staf, px.jam as jam, ps.nama as nama_pasien, px.poli as poli, px.pemeriksaan_fisik as pf from periksas as px join stafs as st on st.id=px.staf_id join pasiens as ps on ps.id=px.pasien_id join diagnosas as dg on dg.id = px.diagnosa_id where st.titel = 'bd' and tanggal like '{$tanggal}%' and (px.poli = 'anc');";
        $periksas = DB::select($query);
        $query = "select min( st.nama ) as nama_staf, count(*) as jumlah from periksas as px join stafs as st on st.id=px.staf_id join pasiens as ps on ps.id=px.pasien_id join diagnosas as dg on dg.id = px.diagnosa_id where st.titel = 'bd' and tanggal like '{$tanggal}%' and (px.poli = 'anc') group by staf_id;";
        $group_by_stafs = DB::select($query);
        //return $periksas;
        return view('laporans.anc', compact('periksas', 'group_by_stafs'));
    }
    public function kb(){
		$tanggal 		= Yoga::blnPrep(Input::get('bulanTahun'));
        $query = "select px.tanggal as tanggal, st.nama as nama_staf, px.jam as jam, ps.nama as nama_pasien, px.poli as poli, px.pemeriksaan_fisik as pf from periksas as px join stafs as st on st.id=px.staf_id join pasiens as ps on ps.id=px.pasien_id where st.titel = 'bd' and tanggal like '{$tanggal}%' and diagnosa_id in (19,941);";
        $periksas_diagnosa_kb = DB::select($query);
        $query = "select min( st.nama ) as nama_staf, count(*) as jumlah from periksas as px join stafs as st on st.id=px.staf_id join pasiens as ps on ps.id=px.pasien_id where st.titel = 'bd' and tanggal like '{$tanggal}%' and diagnosa_id in (19,941) group by staf_id;";
        $group_by_stafs = DB::select($query);
        
        //return $periksas;
        return view('laporans.kb', compact('periksas_diagnosa_kb', 'group_by_stafs'));
    }
}
