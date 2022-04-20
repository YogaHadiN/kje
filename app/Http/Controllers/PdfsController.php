<?php
namespace App\Http\Controllers;

use Input;

use App\Http\Requests;
use Crypt;
use App\Http\Controllers\LaporanLabaRugisController;
use App\Http\Controllers\LaporanNeracasController;
use App\Http\Controllers\QrCodeController;
use App\Http\Controllers\PajaksController;
use App\Http\Controllers\StafsController;
use App\Http\Controllers\PasiensController;
use App\Http\Controllers\AsuransisController;
use App\Http\Controllers\PendapatansController;
use App\Http\Controllers\KirimBerkasController;
use Carbon\Carbon;
use App\Models\Antrian;
use App\Models\Staf;
use App\Models\Terapi;
use App\Models\Classes\Yoga;
use App\Models\Periksa;
use App\Models\PesertaBpjsPerbulan;
use App\Models\KirimBerkas;
use App\Models\Pph21Dokter;
use App\Models\BagiGigi;
use App\Models\Modal;
use App\Models\Pengeluaran;
use App\Models\NoSale;
use App\Models\Asuransi;
use App\Models\CheckoutKasir;
use App\Models\BayarGaji;
use App\Models\NotaJual;
use App\Models\AntrianPoli;
use App\Models\Pasien;
use App\Models\Pendapatan;
use App\Models\JurnalUmum;
use App\Models\FakturBelanja;
use App\Models\PembayaranAsuransi;
use App\Models\Tarif;
use App\Models\Merek;
use App\Models\Rak;
use DB;
use PDF;

class PdfsController extends Controller
{

	/**
	 * Display a listing of the resource.
	 * GET /pdfs
	 *
	 * @return Response
	 */
	public function status($periksa_id)
	{
		return $this->status_private('a5', $periksa_id);
	}
	public function kuitansi($periksa_id)
	{
		$periksa = Periksa::find($periksa_id);

        $pdf = PDF::loadView('pdfs.kuitansi', compact('periksa'))->setPaper('a5')->setOrientation('landscape')->setWarnings(false);
        return $pdf->stream();
	}
	public function getKuitansiview()
	{
        return view('pdfs.kuitansi');
	}
	public function struk($periksa_id)
	{

		$periksa = Periksa::find($periksa_id);
		$pdf = PDF::loadView('pdfs.struk', compact(
			'periksa'
		//))->setPaper(array(0, 0, 210, 810),'Potrait');
		))
		->setOption('page-width', 72)
		->setOption('page-height', 297)
		->setOption('margin-top', 0)
		->setOption('margin-bottom', 0)
		->setOption('margin-right', 0)
		->setOption('margin-left', 0);
        return $pdf->stream();
	}
    
    public function pembelian($faktur_belanja_id){
        $fakturbelanja = FakturBelanja::find($faktur_belanja_id);
        $total = 0;
        if ($fakturbelanja->belanja_id == 1) {
            foreach ($fakturbelanja->pembelian as $pemb) {
                $total += $pemb->harga_beli * $pemb->jumlah;
            }
		} else if ($fakturbelanja->belanja_id == 4) {
            foreach ($fakturbelanja->belanjaPeralatan as $pemb) {
                $total += $pemb->harga_satuan * $pemb->jumlah;
            }
        } else {
            foreach ($fakturbelanja->pengeluaran as $pemb) {
                $total += $pemb->harga_satuan * $pemb->jumlah;
            }
        }
		$pdf = PDF::loadView('pdfs.pembelian', compact(
			'fakturbelanja', 
			'total'
		))
		->setOption('page-width', 72)
		->setOption('page-height', 297)
		->setOption('margin-top', 0)
		->setOption('margin-bottom', 0)
		->setOption('margin-right', 0)
		->setOption('margin-left', 0);
        return $pdf->stream();
    }
    public function penjualan($nota_jual_id){
        $nota_jual = NotaJual::find($nota_jual_id);
		$pdf = PDF::loadView('pdfs.penjualan', compact('nota_jual'))
		->setOption('page-width', 72)
		->setOption('page-height', 297)
		->setOption('margin-top', 0)
		->setOption('margin-bottom', 0)
		->setOption('margin-right', 0)
		->setOption('margin-left', 0);
        return $pdf->stream();


    }
    public function pembayaran_asuransi($pembayaran_asuransi_id){
        $pembayaran = PembayaranAsuransi::find($pembayaran_asuransi_id);
		$pdf = PDF::loadView('pdfs.pembayaran_asuransi', compact('pembayaran'))
		->setOption('page-width', 72)
		->setOption('page-height', 297)
		->setOption('margin-top', 0)
		->setOption('margin-bottom', 0)
		->setOption('margin-right', 0)
		->setOption('margin-left', 0);
        return $pdf->stream();
    }
    public function bayar_gaji_karyawan($bayar_gaji_id){
        $bayar                          = BayarGaji::with('pph21s', 'staf')->where('id',$bayar_gaji_id)->first();
		$bulanPembayaran                = $bayar->tanggal_dibayar->format('Y-m');
		$total_pph_sudah_dibayar        = 0;
		$total_pembayaran_bulan_ini     = 0;
		$total_pph_bulan_ini            = 0;
		$pph21_sudah_dibayar_sebelumnya = 0;
		/* dd($bayar->pph21s->ikhtisar_gaji_bruto); */
		foreach (json_decode($bayar->pph21s->ikhtisar_gaji_bruto, true) as $g) {
			$total_pembayaran_bulan_ini += $bayar['gaji_bruto'];
			$total_pph_bulan_ini        += $bayar['pph21'];
			if ($g['id'] != $bayar->id) {
				$pph21_sudah_dibayar_sebelumnya += $g['pph21'];
			}
		}
		$total_gaji = $bayar->gaji_pokok + $bayar->bonus;
		$returnData = compact(
			'bayar',
			'total_gaji',
			'total_pembayaran_bulan_ini',
			'total_pph_sudah_dibayar',
			'pph21_sudah_dibayar_sebelumnya',
			'total_pph_bulan_ini'
		);

		$pdf = PDF::loadView('pdfs.struk_gaji', $returnData)
			->setOption('page-width', 72)
			->setOption('page-height', 297)
			->setOption('margin-top', 0)
			->setOption('margin-bottom', 0)
			->setOption('margin-right', 0)
			->setOption('margin-left', 0);
        return $pdf->stream();

    }
    public function notaz($checkout_kasir_id){
        $notaz = CheckoutKasir::find($checkout_kasir_id);
		$buka_kasir = CheckoutKasir::find($checkout_kasir_id - 1)->created_at;
        $detils = json_decode( $notaz->detil_pengeluarans, true );
        $detils_tangan = json_decode( $notaz->detil_pengeluaran_tangan, true );
        $modals = json_decode( $notaz->detil_modals, true );
        $pengeluarans = JurnalUmum::whereIn('id', $detils)->get();
        $pengeluarans_tangan = JurnalUmum::whereIn('id', $detils_tangan)->get();
        $modals = JurnalUmum::whereIn('id', $modals)->get();
		$total_modal = 0;
		foreach ($modals as $mdl) {
			$total_modal += $mdl->nilai;
		}

		$total_pengeluaran = 0;
		foreach ($pengeluarans as $mdl) {
			$total_pengeluaran += $mdl->nilai;
		}

		$total_pengeluaran_tangan = 0;
		foreach ($pengeluarans_tangan as $mdl) {
			$total_pengeluaran_tangan += $mdl->nilai;
		}
        $total_pemasukan = 0;
        foreach ($notaz->checkoutDetail as $cd) {
            $total_pemasukan += $cd->nilai;
        }
		//return $total_nilai;
		$pdf = PDF::loadView('pdfs.notaz', compact(
			'notaz', 
			'pengeluarans',
			'pengeluarans_tangan',
			'modals', 
			'buka_kasir', 
			'total_modal', 
			'total_pengeluaran',
			'total_pengeluaran_tangan',
			'total_pemasukan'
		))
		->setOption('page-width', 72)
		->setOption('page-height', 297)
		->setOption('margin-top', 0)
		->setOption('margin-bottom', 0)
		->setOption('margin-right', 0)
		->setOption('margin-left', 0);
        return $pdf->stream();
    }
    public function rc($modal_id){
         $modal = Modal::find($modal_id);

		 $pdf = pdf::loadview('pdfs.rc', compact('modal'))
		->setOption('page-width', 72)
		->setOption('page-height', 297)
		->setOption('margin-top', 0)
		->setOption('margin-bottom', 0)
		->setOption('margin-right', 0)
		->setOption('margin-left', 0);
        return $pdf->stream();

    }
    public function ns($no_sale_id){
        $nosale = NoSale::find($no_sale_id);
        
		$pdf = pdf::loadview('pdfs.ns', compact('nosale'))
		->setOption('page-width', 72)
		->setOption('page-height', 297)
		->setOption('margin-top', 0)
		->setOption('margin-bottom', 0)
		->setOption('margin-right', 0)
		->setOption('margin-left', 0);
        return $pdf->stream();
    }

	public function pengeluaran($id){
		
        $pengeluaran = Pengeluaran::find($id);
		$pdf = pdf::loadview('pdfs.pengeluaran', compact('pengeluaran'))
		->setOption('page-width', 72)
		->setOption('page-height', 297)
		->setOption('margin-top', 0)
		->setOption('margin-bottom', 0)
		->setOption('margin-right', 0)
		->setOption('margin-left', 0);
        return $pdf->stream();
	}
	public function pendapatan($id){
		
        $pendapatan = Pendapatan::find($id);
		$pdf = pdf::loadview('pdfs.pendapatan', compact('pendapatan'))
		->setOption('page-width', 72)
		->setOption('page-height', 297)
		->setOption('margin-top', 0)
		->setOption('margin-bottom', 0)
		->setOption('margin-right', 0)
		->setOption('margin-left', 0);
        return $pdf->stream();
	}
	
    public function merek(){
        $mereks = Merek::all();
		$pdf = pdf::loadview('pdfs.merek', compact('mereks'))
		->setOption('page-width', 72)
		->setOption('page-height', 297)
		->setOption('margin-top', 0)
		->setOption('margin-bottom', 0)
		->setOption('margin-right', 0)
		->setOption('margin-left', 0);
        return $pdf->stream();
    }
	public function dispensing($rak_id, $mulai, $akhir){

		// return 'mulai = ' . $mulai . ' akhir = ' . $akhir . ' rak_id = ' . $rak_id . ' ';
		//$dispensings = DB::select("SELECT id, tanggal, rak_id, sum(keluar) as keluar, sum(masuk) as masuk, dispensable_id FROM dispensings where tanggal <= '{$akhir}' AND tanggal >= '{$mulai}' AND rak_id like '{$rak_id}' group by tanggal");
		$query = "SELECT id, ";
		$query .= "tanggal, ";
		$query .= "rak_id, ";
		$query .= "sum(keluar) as keluar, ";
		$query .= "sum(masuk) as masuk, ";
		$query .= "dispensable_id, ";
		$query .= "dispensable_type ";
		$query .= "FROM dispensings ";
		$query .= "where tanggal <= '{$akhir}' ";
		$query .= "AND tanggal >= '{$mulai}' ";
		$query .= "AND rak_id like '{$rak_id}' ";
		$query .= "group by tanggal";

		$dispensings = DB::select($query);
		// $dispensings = Dispensing::where('tanggal', '>=', $mulai)->where('tanggal', '<=', $akhir)->where('rak_id', 'like', $rak_id)->groupBy('rak_id')->get();
		$rak = Rak::find($rak_id);
		$raks = Rak::all();



		$pdf = pdf::loadview('pdfs.dispensing', compact(
			'dispensings', 
			'rak',  
			'mulai',  
			'akhir',  
			'raks'
		))->setPaper('a5')->setOrientation('potrait')->setWarnings(false);
        return $pdf->stream();


	}
	public function status_a4($periksa_id){
		return $this->status_private('a4', $periksa_id);
	}
	private function status_private($a, $periksa_id){
		header ('Content-type: text/html; charset=utf-8');
		$periksa    = Periksa::with('pasien', 'transaksii')->where('id', $periksa_id)->first();

		/* dd( $periksa->gdp_bpjs ); */

		//cek apakah pasien ini sudah pernah periksa GDS sebelumnya
		//
		//
		//
		$tarifObatFlat = Tarif::where('asuransi_id', $periksa->asuransi_id)->where('jenis_tarif_id', '9')->first()->biaya;		


		$bayarGDS   = false;
		$transaksi_before = json_decode($periksa->transaksi, true);
		// return 'oke';
		if ($periksa->asuransi_id == 32) {
			foreach ($transaksi_before as $key => $value) {
				if (($value['jenis_tarif_id'] == '116')) {
					$bayarGDS = Yoga::cekGDSBulanIni($periksa->pasien, $periksa)['bayar'];
				}
			}
			$cetak_usg = '1';
		} else {
			$cetak_usg = '2';
		}

		// return $periksa->register_anc->register_hamil->riwobs;
		$puyerAdd = false;
		foreach ($periksa->terapii as $key => $v) {
			if ($v->merek_id < 0) {
				$puyerAdd = true;
				break;
			}
		}

		$transaksis = $periksa->transaksi;
		$biaya = 0;
		$transaksis = json_decode($transaksis, true);
		// return $t
		foreach ($transaksis as $transaksi) {
			$biaya += $transaksi['biaya'];
			if ($transaksi['jenis_tarif_id'] == '9') {
				$biayaObat = $transaksi['biaya'];
			}
		}
		$qr = new QrCodeController;
		$base64 = $qr->inPdf('http://www.klinikjatielok.com/validasi/surat_sakit/' . $periksa->id);
		$pdf = PDF::loadView('pdfs.status', compact(
			'periksa', 
			'base64', 
			'cetak_usg', 
			'puyerAdd', 
			'bayarGDS', 
			'biaya', 
			'biayaObat', 
			'tarifObatFlat'
		))->setPaper($a)->setOrientation('landscape')->setWarnings(false);
        // return view('pdfs.status', compact('periksa', 'cetak_usg', 'puyerAdd', 'bayarGDS'));
        return $pdf->stream();

	}
	public function formUsg($id, $asuransi_id){
		$pasien = Pasien::find($id);
		$asuransi = Asuransi::find($asuransi_id);
		$pdf = PDF::loadView('pdfs.form_usg', compact(
			'pasien',
			'asuransi'
		))->setPaper('a5')->setOrientation('landscape')->setWarnings(false);
        // return view('pdfs.status', compact('periksa', 'cetak_usg', 'puyerAdd', 'bayarGDS'));
        return $pdf->stream();
	}
	
	public function laporanLabaRugi($tanggal_awal, $tanggal_akhir){
		$lap   = new LaporanLabaRugisController;
		$query = $lap->tempLaporanLabaRugiRangeByDate($tanggal_awal, $tanggal_akhir);
		/* dd($query); */
		/* dd($query['pendapatan_usahas']['akuns'][0]['coa']); */
		$pdf   = PDF::loadView(
					'pdfs.laporan_laba_rugi', 
					$query)
				->setPaper('a4');
        return $pdf->stream();
	}
	public function laporanLabaRugiPerTahun($tahun){
		return 'perTahun';
	}


	public function laporanNeraca($tahun){
		$th = new LaporanNeracasController;
		$temp = $th->temp($tahun);
		
		$akunAktivaLancar      = $temp['akunAktivaLancar'];
		$total_harta           = $temp['total_harta'];
		$akunHutang            = $temp['akunHutang'];
		$akunModal             = $temp['akunModal'];
		$laba_tahun_berjalan   = $temp['laba_tahun_berjalan'];
		$akunAktivaTidakLancar = $temp['akunAktivaTidakLancar'];

		$pdf = PDF::loadView('pdfs.laporan_neraca', compact(
			'akunAktivaLancar',
			'total_harta',
			'akunHutang',
			'akunModal',
			'laba_tahun_berjalan',
			'akunAktivaTidakLancar'
		))
			->setPaper('a4')
			->setOrientation('landscape')
			->setOption('margin-bottom', 10);
		return $pdf->stream();
	}
	public function jurnalUmum($bulan, $tahun){
		$ju = JurnalUmum::with('coa', 'jurnalable')->where('created_at', 'like', $tahun . '-' . $bulan . '%')
			->get();
		$jurnals = [];
		foreach ($ju as $j) {
			$jurnals[$j->jurnalable_id.$j->jurnalable_type][] = $j;
		}

		$pdf = PDF::loadView('pdfs.jurnal_umum', compact(
			'jurnals'
		))
			->setPaper('a4')
			->setOption('margin-bottom', 10);
		return $pdf->stream();
	}
	
	public function bukuBesar($bulan, $tahun, $coa_id){
		$jurnalumums = JurnalUmum::where('coa_id', $coa_id)
		->where('created_at', 'like', $tahun . '-' . $bulan . '%')
		->get();

		$pdf = PDF::loadView('pdfs.buku_besar', compact(
			'jurnalumums'
		))
			->setPaper('a4')
			->setOption('margin-bottom', 0);
		return $pdf->stream();
	}

	public function bagiHasilGigi($id)
	{
		$bayar = BagiGigi::find($id);

		$pembayaran_bulan_ini = BagiGigi::where('tanggal_mulai', 'like', $bayar->tanggal_mulai->format('Y-m') . '%' )->get();
		$total_pembayaran_bulan_ini = 0;
		$total_pph_bulan_ini = 0;
		foreach ($pembayaran_bulan_ini as $b) {
			$total_pembayaran_bulan_ini += $b->nilai;
			$total_pph_bulan_ini += $b->pph21;
		}

		$pdf = PDF::loadView('pdfs.bagi_hasil_gigi', compact(
			'bayar',
			'pembayaran_bulan_ini',
			'total_pph_bulan_ini',
			'total_pembayaran_bulan_ini'
		))
		->setOption('page-width', 72)
		->setOption('page-height', 297)
		->setOption('margin-top', 0)
		->setOption('margin-bottom', 0)
		->setOption('margin-right', 0)
		->setOption('margin-left', 0);
        return $pdf->stream();
	}
	public function pph21dokter($id){
		$pph = Pph21Dokter::find($id);
	}
	public function amortisasi($tahun){
		$pajak        = new PajaksController;
		$input_hartas = $pajak->queryAmortisasi( 'harta', 'input_hartas', 'App\\\Models\\\InputHarta', 'bp.tanggal_beli', $tahun);
		$peralatans   = $pajak->queryAmortisasi( 'peralatan', 'belanja_peralatans', 'App\\\Models\\\BelanjaPeralatan', 'fb.tanggal', $tahun);
		$jumlah_penyusutan = 0;
		$zuzuts = [];

		$array = [];
		foreach ($peralatans as $p) {
			$jumlah_penyusutan += $p->total_penyusutan - $p->susut_fiskal_tahun_lalu;
			$zuzuts[]= $p->total_penyusutan - $p->susut_fiskal_tahun_lalu;
			$array[$p->masa_pakai][] = $p;
		}

		foreach ($input_hartas as $p) {
			if ( $p->masa_pakai < 20 ) {
				$jumlah_penyusutan       += $p->total_penyusutan - $p->susut_fiskal_tahun_lalu;
				$zuzuts[]                 = $p->total_penyusutan - $p->susut_fiskal_tahun_lalu;
				$array[$p->masa_pakai][]  = $p;
			}
		}

		if (!isset( $array[4] )) {
			$array[4] = [];
		}
		if (!isset( $array[8] )) {
			$array[8] = [];
		}
		if (!isset( $array[16] )) {
			$array[16] = [];
		}
		if (!isset( $array[20] )) {
			$array[20] = [];
		}
		$peralatans = $array;

		$bahan_bangunans = $pajak->queryAmortisasi( 'keterangan', 'bahan_bangunans', 'App\\\Models\\\BahanBangunan', 'bp.tanggal_renovasi_selesai', $tahun);
		$array = [];
		foreach ($bahan_bangunans as $bb) {
			$jumlah_penyusutan +=  $bb->total_penyusutan - $bb->susut_fiskal_tahun_lalu;
			$zuzuts[]= $bb->total_penyusutan - $bb->susut_fiskal_tahun_lalu;
			$array[$bb->permanen][] = $bb;
		}
		if (!isset( $array[0] )) {
			$array[0] = [];
		}
		if (!isset( $array[1] )) {
			$array[1] = [];
		}
		foreach ($input_hartas as $p) {
			if ( $p->masa_pakai == 20 ) {
				$jumlah_penyusutan       += $p->total_penyusutan - $p->susut_fiskal_tahun_lalu;
				$zuzuts[]                 = $p->total_penyusutan - $p->susut_fiskal_tahun_lalu;
				$array[1][]  = $p;
			}
		}
		$bahan_bangunans = $array;

		/* foreach ($input_hartas as $input_harta) { */
		/* 	if ( $input_harta->masa_pakai == '20' ) { */
		/* 		$bahan_bangunans = $bahan_bangunans-> */
		/* 	} */
		/* } */


		$pdf = PDF::loadView('pdfs.amortisasi', compact(
			'peralatans',
			'tahun',
			'jumlah_penyusutan',
			'bahan_bangunans'
		))
		->setPaper('legal')
		->setOrientation('landscape')
		->setOption('margin-bottom', 10);
        return $pdf->stream();
	}
	public function peredaranBruto($tahun){
		$pb = new PajaksController;
		$peredaranBruto = $pb->queryPeredaranBruto($tahun);

		$total = 0;
		foreach ($peredaranBruto as $pb) {
			$total += $pb->total;
		}
		$pdf = PDF::loadView('pdfs.peredaranBruto', compact(
			'peredaranBruto',
			'total'
		))
		->setPaper('a4')
		->setOrientation('landscape')
		->setOption('margin-bottom', 10);
        return $pdf->stream();

	}
	public function kuatansiPerBulan($bulan, $tahun){

		$periksas = Periksa::where('tanggal', 'like', $tahun . '-' . $bulan . '%')->get();

		return view('pdfs.kuitansiPerBulan', compact(
			'periksas'
		));



		
	}
	public function strukPerBulan($bulan, $tahun)
	{

		$periksas          = Periksa::where('tanggal', 'like', $tahun . '-' . $bulan . '%')
									->where('tunai' , '>', '0')
									->take(20)
									->get();
		$pdf = PDF::loadView('pdfs.multiStruk', compact(
			'periksas'
		//))->setPaper(array(0, 0, 210, 810),'Potrait');
		))
		->setOption('page-width', 72)
		->setOption('page-height', 297)
		->setOption('margin-top', 0)
		->setOption('margin-bottom', 0)
		->setOption('margin-right', 0)
		->setOption('margin-left', 0);
        return $pdf->stream();
	}
	
	public function strukPerTanggal($tahun, $bulan, $tanggal)
	{

		$tanggal = $tahun . '-' . $bulan . '-' . $tanggal;
		$periksas          = Periksa::where('tanggal', $tanggal)
									->where('tunai' , '>', '0')
									->get();
		$nota_juals          = NotaJual::where('tanggal', $tanggal)
									->get();
		$pendapatans          = Pendapatan::where('created_at','like', $tanggal . '%')
									->get();
		$pdf = PDF::loadView('pdfs.multiStruk', compact(
			'periksas',
			'pendapatans',
			'nota_juals'
		//))->setPaper(array(0, 0, 210, 810),'Potrait');
		))
		->setOption('page-width', 72)
		->setOption('page-height', 297)
		->setOption('margin-top', 0)
		->setOption('margin-bottom', 0)
		->setOption('margin-right', 0)
		->setOption('margin-left', 0);
        return $pdf->stream();
	}
	public function piutangAsuransiBelumDibayar($asuransi_id, $mulai, $akhir){

		$asuransi             = Asuransi::find( $asuransi_id );
		$pendapatanController = new PendapatansController;
        $belum_dibayars       = $pendapatanController->belumDibayar( $mulai, $akhir, $asuransi_id );

		$total_piutang       = 0;
		$total_sudah_dibayar = 0;
		$total_sisa_piutang  = 0;

		foreach ($belum_dibayars as $belum) {
			$total_piutang       += $belum->piutang;
			$total_sudah_dibayar += $belum->total_pembayaran;
			$total_sisa_piutang  += $belum->piutang - $belum->total_pembayaran;
		}

		$pdf = PDF::loadView('pdfs.piutangAsuransiBelumDibayar', compact(
			'asuransi',
			'mulai',
			'total_piutang',
			'total_sudah_dibayar',
			'total_sisa_piutang',
			'akhir',
			'belum_dibayars'
		))->setPaper('a4')->setOrientation('portrait')->setWarnings(false);

		return $pdf->stream();
	}
	public function piutangAsuransiSudahDibayar($asuransi_id, $mulai, $akhir){
		$asuransi             = Asuransi::find( $asuransi_id );
		$pendapatanController = new PendapatansController;
        $sudah_dibayars       = $pendapatanController->sudahDibayar( $mulai, $akhir, $asuransi_id );

		$total_tunai          = 0;
		$total_piutang        = 0;
		$total_sudah_dibayar  = 0;
		$total_sisa_piutang   = 0;

		foreach ($sudah_dibayars as $sudah) {
			$total_tunai         += $sudah->tunai;
			$total_piutang       += $sudah->piutang;
			$total_sudah_dibayar += $sudah->sudah_dibayar;
			$total_sisa_piutang  += $sudah->piutang - $sudah->sudah_dibayar;
		}

		$pdf = PDF::loadView('pdfs.piutangAsuransiSudahDibayar', compact(
			'asuransi',
			'mulai',
			'pembayaran_asuransi',
			'total_piutang',
			'total_tunai',
			'total_sudah_dibayar',
			'total_sisa_piutang',
			'akhir',
			'sudah_dibayars',
			'total_pembayaran'
		))->setPaper('a4')->setOrientation('portrait')->setWarnings(false);
		return $pdf->stream();
	}
	public function piutangAsuransi($asuransi_id, $mulai, $akhir){

		$asuransiController = new AsuransisController;

		$piutangs = $asuransiController->querySemuaPiutangPerBulan($asuransi_id, $mulai, $akhir  );

		$asuransi = Asuransi::find( $asuransi_id );

		$total_tunai         = 0;
		$total_piutang       = 0;
		$total_sudah_dibayar = 0;

		foreach ($piutangs as $piutang) {
			$total_tunai         += $piutang->tunai;
			$total_piutang       += $piutang->piutang;
			$total_sudah_dibayar += $piutang->sudah_dibayar;
		}

		$pdf = PDF::loadView('pdfs.piutangAsuransi', compact(
			'mulai',
			'asuransi',
			'akhir',
			'piutangs',
			'total_piutang',
			'total_sudah_dibayar',
			'total_tunai'
		))->setPaper('a4')->setOrientation('portrait')->setWarnings(false);
		return $pdf->stream();
	}
	public function kirim_berkas($id){
		header ('Content-type: text/html; charset=utf-8');
		$kirimBerkas = new KirimBerkasController;
		$id          = $kirimBerkas->controllerId($id);

		$kirim_berkas    = KirimBerkas::with(
			'petugas_kirim.staf', 
			'petugas_kirim.role_pengiriman', 
			'invoice.periksa.asuransi')->where('id', $id)->first();

		$jumlah_tagihan = 0;
		$total_tagihan = 0;
		foreach ($kirim_berkas->rekap_tagihan as $tagihan) {
			$jumlah_tagihan += $tagihan['jumlah_tagihan'];
			$total_tagihan += $tagihan['total_tagihan'];
			
		}


        $pdf = PDF::loadView('pdfs.kirim_berkas', compact('kirim_berkas', 'jumlah_tagihan', 'total_tagihan'))->setPaper('A5')->setOrientation('landscape')->setWarnings(false);
        return $pdf->stream();

	}
	public function antrian($id){
		$antrian= Antrian::find($id);
		$pdf = PDF::loadView('pdfs.antrian', compact(
			'antrian'
		))
		->setOption('page-width', 72)
		->setOption('page-height', 297)
		->setOption('margin-top', 0)
		->setOption('margin-bottom', 0)
		->setOption('margin-right', 0)
		->setOption('margin-left', 0);
        return $pdf->stream();
	}
	public function laporanLabaRugiBikinan($tanggal_awal, $tanggal_akhir){
		$lap   = new LaporanLabaRugisController;
		$query = $lap->templaporanlabarugibikinan($tanggal_awal, $tanggal_akhir);
		$pdf   = PDF::loadView(
					'pdfs.laporan_laba_rugi', 
					$query)
				->setPaper('a4');
        return $pdf->stream();
	}
	public function prolanisHipertensiPerBulan($bulanTahun){
		$prolanis_ht          = $this->prolanisHT($bulanTahun);
		$bulanTahun           = Carbon::createFromFormat('Y-m', $bulanTahun);
		$jumlah_ht_terkendali = 0;
		foreach ($prolanis_ht as $p) {
			if ( $this->htTerkendali($p) ) {
				$jumlah_ht_terkendali++;
			}
		}
		$jumlah_denominator_ht = PesertaBpjsPerbulan::where('bulanTahun', $bulanTahun->format('Y-m-01'))->first()->jumlah_ht;
		$pdf                   = PDF::loadView('pdfs.prolanisHipertensiPerBulan', compact(
			'prolanis_ht',
			'jumlah_ht_terkendali',
			'jumlah_denominator_ht',
			'bulanTahun'
		))->setPaper('a4')->setOrientation('portrait')->setWarnings(false);
		return $pdf->stream();
	}
	public function prolanisDmPerBulan($bulanTahun){
		$psn             = new PasiensController;
		$data            = $psn->queryDataProlanisPerBulan($bulanTahun);
		$prolanis_dm     = [];
		foreach ($data as $d) {
			$prolanis_dm = $psn->templateProlanisPeriksa($prolanis_dm, $d, 'prolanis_dm');
		}
		$bulanTahun = Carbon::createFromFormat('Y-m', $bulanTahun);
		$jumlah_denominator_dm = PesertaBpjsPerbulan::where('bulanTahun', $bulanTahun->format('Y-m-01'))->first()->jumlah_dm;

		$jumlah_dm_terkendali = 0;
		foreach ($prolanis_dm as $p) {
			if ( isset( $p['gula_darah'] ) ) {
				$gula_darah = (int) filter_var( $p['gula_darah'] , FILTER_SANITIZE_NUMBER_INT);
				if ( $gula_darah < 130  ) {
					$jumlah_dm_terkendali++;
				}
			}
		}

		$pdf             = PDF::loadView('pdfs.prolanisDmPerBulan', compact(
			'prolanis_dm',
			'jumlah_dm_terkendali',
			'jumlah_denominator_dm',
			'bulanTahun'
		))->setPaper('a4')->setOrientation('portrait')->setWarnings(false);
		return $pdf->stream();

	}
	public function hasilAntigen($periksa_id){
		$periksa      = Periksa::with('pasien')->where('id', $periksa_id)->first();
		$hasil = '';
		/* dd( $periksa ); */
		foreach (json_decode($periksa->transaksi, true) as $transaksi) {
			if ( $transaksi['jenis_tarif_id'] == '404' ) {
				$hasil = $transaksi['keterangan_tindakan'];
			}
		}
		$qr     = new QrCodeController;
		$base64 = $qr->inPdf('http://www.klinikjatielok.com/validasi/antigen/' . $periksa->id);
		$options = [
			'margin-top'    => 50,
			'margin-right'  => 50,
			'margin-bottom' => 50,
			'margin-left'   => 50,
		];
		if ( $hasil == 'negatif'	) {
			$hasil = 'NON REAKTIF / NEGATIF' ;
		} else if ( $hasil == 'positif'	) {
			$hasil = 'REAKTIF / POSITIF' ;
		}
		$antigen = true;
		$pdf             = PDF::loadView('pdfs.hasil_rapid', compact(
			'periksa',
			'antigen',
			'base64',
			'hasil'
		))->setPaper('a4')
					->setOrientation('portrait')
					->setWarnings(false)
					->setOption('margin-left', 20)
					->setOption('margin-right', 20);
		return $pdf->stream();
		
	}
	public function hasilAntibodi($periksa_id){
		$periksa = Periksa::with('pasien')->where('id', $periksa_id)->first();
		$hasil   = '';
		foreach (json_decode($periksa->transaksi, true) as $transaksi) {
			if ( $transaksi['jenis_tarif_id'] == '403' ) {
				$hasil = $transaksi['keterangan_tindakan'];
			}
		}
		$qr     = new QrCodeController;
		$base64 = $qr->inPdf('http://www.klinikjatielok.com/validasi/antibodi/' . $periksa->id);
		$options = [
			'margin-top'    => 50,
			'margin-right'  => 50,
			'margin-bottom' => 50,
			'margin-left'   => 50,
		];
		if ( $hasil == 'negatif'	) {
			$hasil = 'NON REAKTIF / NEGATIF' ;
		} else if ( $hasil == 'positif'	) {
			$hasil = 'REAKTIF / POSITIF' ;
		}
		$antigen = false;
		$pdf             = PDF::loadView('pdfs.hasil_rapid', compact(
			'periksa',
			'antigen',
			'base64',
			'hasil'
		))->setPaper('a4')
					->setOrientation('portrait')
					->setWarnings(false)
					->setOption('margin-left', 20)
					->setOption('margin-right', 20);
		return $pdf->stream();
	}
	public function htTerkendali($p){
		$tanggal_lahir   = is_object($p) ? $p->pasien->tanggal_lahir : $p['tanggal_lahir'];
		$tanggal_periksa = is_object($p) ? $p->tanggal : $p['tanggal'];
		$sistolik        = is_object($p) ? $p->sistolik  : $p['sistolik'];
		$diastolik       = is_object($p) ? $p->diastolik   : $p['diastolik'];

		$tanggal_lahir   = Carbon::parse( $tanggal_lahir);
		$tanggal_periksa = Carbon::parse( $tanggal_periksa);
		$usia            = $tanggal_lahir->diffInYears($tanggal_periksa);

		if (
			(
				in_array( $usia, range(18, 64) ) && //jika usia diantara 18 dan 65 tahun
				(!is_null($sistolik) && $sistolik<= 130 && $sistolik >= 120) && //sistolik dibawah sama dengan 130 dan diatas sama dengan 120
				(!is_null($diastolik) && $diastolik < 80 && $diastolik >= 70) &&// dan diastolik dibawah 80 dan diatas sama dengan 70
			    !is_null($tanggal_lahir)	// dan diastolik antara 70 dan 79
			) || (
				$usia > 64 && // jika usia diatas 64 tahun
				(!is_null($sistolik) && $sistolik< 140 && $sistolik >= 130) && // sistolik dibawah 140 dan diatas sama dengan 130
				(!is_null($diastolik) && $diastolik < 80 && $diastolik >= 70) &&// dan diastolik dibawah 80 dan diatas sama dengan 70
			    !is_null($tanggal_lahir)	// dan diastolik antara 70 dan 79
			)
		) {
			return true;
		} else {
			return false;
		}
	}
	public function prolanisHT($bulanTahun){
		$psn             = new PasiensController;
		$data            = $psn->queryDataProlanisPerBulan($bulanTahun);
		$prolanis_ht     = [];
		foreach ($data as $d) {
			$prolanis_ht = $psn->templateProlanisPeriksa($prolanis_ht, $d, 'prolanis_ht');
		}
		return $prolanis_ht;

	}
	public function label_obat($id){

		$periksa = Periksa::with('terapii.merek.rak.formula.komposisi.generik', 'pasien')->where('id', $id)->first();

		$nama = $periksa->pasien->nama;

		$exploded_nama = explode(" ", $nama);
		$printed_nama = $exploded_nama[0];
		if (isset( $exploded_nama[1] )) {
			$printed_nama .=  ' ' . $exploded_nama[1];
		}

		$pdf = PDF::loadView('pdfs.label_obat', compact(
			'periksa',
			'printed_nama'
		))
			->setOption('page-width', 40)
			->setOption('page-height', 60)
			->setOption('margin-left', 0)
			->setOption('margin-top', 0)
			->setOption('margin-bottom', 0)
			->setOption('margin-right', 0)
			->setOrientation('landscape')
			->setWarnings(false);
        // return view('pdfs.status', compact('periksa', 'cetak_usg', 'puyerAdd', 'bayarGDS'));
        return $pdf->stream();
	}

	public function jumlahPasienPerTahun($id, $tahun){
		$stfc = new StafsController;
		$pdf   = PDF::loadView(
				'pdfs.jumlah_pasien_tahunan', [ 
					'jumlah' => $stfc->jumlahPasienTahunan($id, $tahun),
					'staf'   => Staf::find($id) ,
					'tahun'  => $tahun
				])
				->setPaper('a4')
				->setOption('footer-right', '[page]');
        return $pdf->stream();
	}
	
}
