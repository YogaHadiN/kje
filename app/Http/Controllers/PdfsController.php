<?php
namespace App\Http\Controllers;

use Input;

use App\Http\Requests;
use App\Http\Controllers\LaporanLabaRugisController;
use App\Http\Controllers\LaporanNeracasController;
use App\Classes\Yoga;
use App\Periksa;
use App\Modal;
use App\BayarDokter;
use App\Pengeluaran;
use App\NoSale;
use App\Asuransi;
use App\CheckoutKasir;
use App\BayarGaji;
use App\NotaJual;
use App\AntrianPoli;
use App\Pasien;
use App\Pendapatan;
use App\JurnalUmum;
use App\FakturBelanja;
use App\PembayaranAsuransi;
use App\Tarif;
use App\Merek;
use App\Rak;
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

		// return dd($periksa->tindakan_html[0]['jenis_tarif_id']);
		$terbilang = 0;
		$transaksis = $periksa->transaksi; 
		$transaksis = json_decode($transaksis, true);

		foreach ($transaksis as $transaksi) {
			$terbilang += $transaksi['biaya'];
		}

		$terbilang = ucwords(Yoga::terbilang($terbilang)) . ' Rupiah';



        $pdf = PDF::loadView('pdfs.kuitansi', compact('periksa', 'terbilang'))->setPaper('a5')->setOrientation('landscape')->setWarnings(false);
        // $pdf = PDF::loadView('pdfs.kuitansi');
        return $pdf->stream();
	}
	public function getKuitansiview()
	{
        return view('pdfs.kuitansi');
	}
	public function struk($periksa_id)
	{
		$periksa = Periksa::find($periksa_id);
        $transaksis = $periksa->transaksii;
        $total_biaya = 0;
        $dibayar_asuransi = 0;
        $dibayar_pasien = 0;
        $pembayaran = 0;
        $kembalian = 0;
        $bhp = 0;
        foreach ($transaksis as $trx) {
            if ($trx->jenis_tarif_id != 147 && $trx->jenis_tarif_id != 148) {
                $total_biaya += $trx->biaya;
            }
            if ($trx->jenis_tarif_id == 147) {
                $pembayaran = $trx->biaya;
            }
            if ($trx->jenis_tarif_id == 148) {
                $kembalian = $trx->biaya;
            }
            if ($trx->jenis_tarif_id == 149) {
                $dibayar_asuransi = $trx->biaya;
            }
            if ($trx->jenis_tarif_id == 150) {
                $dibayar_pasien = $trx->biaya;
            }
            if ($trx->jenis_tarif_id == 140) {
                $bhp = $trx->biaya;
            }
        }
        //return dd( $transaksis );
        $trxa = json_encode($transaksis);
        $trxa = json_decode($trxa, true);
        foreach ($trxa as $k=>$trx) {
            if ($trx['jenis_tarif_id'] == 9) {
                $trxa[$k]['biaya'] = Yoga::buatrp($trx['biaya'] + $bhp);
                $trxa[$k]['jenis_tarif'] = $transaksis[$k]->jenisTarif->jenis_tarif;

            }else if($trx['jenis_tarif_id'] == 140){
                unset($trxa[$k]);
            } else {
                $trxa[$k]['biaya'] = Yoga::buatrp($trx['biaya']);
                $trxa[$k]['jenis_tarif'] = $transaksis[$k]->jenisTarif->jenis_tarif;
            }
        }
        $total_biaya      = Yoga::buatrp( $total_biaya );
        $dibayar_asuransi = Yoga::buatrp( $dibayar_asuransi );
        $dibayar_pasien   = Yoga::buatrp( $dibayar_pasien );
        $pembayaran       = Yoga::buatrp( $pembayaran );
        $kembalian        = Yoga::buatrp( $kembalian );
        //return dd( $trxa );
		$pdf = PDF::loadView('pdfs.struk', compact(
			'trxa', 
			'periksa', 
			'total_biaya', 
			'dibayar_asuransi', 
			'dibayar_pasien', 
			'pembayaran', 
			'kembalian'
		//))->setPaper(array(0, 0, 210, 810),'Potrait');
		))
		->setOption('page-width', 80)
		->setOption('page-height', 297)
		->setOption('margin-top', 0)
		->setOption('margin-bottom', 0)
		->setOption('margin-right', 0)
		->setOption('margin-left', 0);
        return $pdf->stream();
	}
    public function jasa_dokter($bayar_dokter_id){
        $bayar = BayarDokter::find($bayar_dokter_id);
		$pdf = PDF::loadView('pdfs.jasa_dokter', compact('bayar'))
				->setOption('page-width', 80)
				->setOption('page-height', 297)
				->setOption('margin-top', 0)
				->setOption('margin-bottom', 0)
				->setOption('margin-right', 0)
				->setOption('margin-left', 0);
        return $pdf->stream();
    }
    
    public function pembelian($faktur_belanja_id){
        $fakturbelanja = FakturBelanja::find($faktur_belanja_id);
		//return dd( $fakturbelanja );
        $total = 0;
        if ($fakturbelanja->belanja_id == 1) {
            foreach ($fakturbelanja->pembelian as $pemb) {
                $total += $pemb->harga_beli * $pemb->jumlah;
            }
		} else if ($fakturbelanja->belanja_id == 4) {
			//return dd( $fakturbelanja->belanjaPeralatan );
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
		->setOption('page-width', 80)
		->setOption('page-height', 297)
		->setOption('margin-top', 0)
		->setOption('margin-bottom', 0)
		->setOption('margin-right', 0)
		->setOption('margin-left', 0);
        return $pdf->stream();
    }
    public function penjualan($nota_jual_id){
        $nota_jual = NotaJual::find($nota_jual_id);
        $total = 0;
        if ($nota_jual->tipe_jual_id == 1) {
            foreach ($nota_jual->penjualan as $penj) {
                $total += $penj->harga_jual * $penj->jumlah;
            }
        } else if($nota_jual->tipe_jual_id == 2){
            foreach ($nota_jual->pendapatan as $penj) {
                $total += $penj->biaya;
            }
        }

		$pdf = PDF::loadView('pdfs.penjualan', compact('nota_jual', 'total'))
		->setOption('page-width', 80)
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
		->setOption('page-width', 80)
		->setOption('page-height', 297)
		->setOption('margin-top', 0)
		->setOption('margin-bottom', 0)
		->setOption('margin-right', 0)
		->setOption('margin-left', 0);
        return $pdf->stream();
    }
    
    public function bayar_gaji_karyawan($bayar_gaji_id){
        $bayar = BayarGaji::find($bayar_gaji_id);
		$pdf = PDF::loadView('pdfs.bayar_gaji_karyawan', compact(
			'bayar'
		))
		->setOption('page-width', 80)
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
		->setOption('page-width', 80)
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
		->setOption('page-width', 80)
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
		->setOption('page-width', 80)
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
		->setOption('page-width', 80)
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
		->setOption('page-width', 80)
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
		->setOption('page-width', 80)
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
		$dispensings = DB::select("SELECT id, tanggal, rak_id, sum(keluar) as keluar, sum(masuk) as masuk, dispensable_id, dispensable_type FROM dispensings where tanggal <= '{$akhir}' AND tanggal >= '{$mulai}' AND rak_id like '{$rak_id}' group by tanggal");
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
		$periksa    = Periksa::find($periksa_id);

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
		// return $periksa->asuransi->tipe_asuransi;
		// return $biayaObat;
		// return $tarifObatFlat;

		// return dd($transaksis);

		// return $periksa->registerAnc->presentasi_id;

        $pdf = PDF::loadView('pdfs.status', compact('periksa', 'cetak_usg', 'puyerAdd', 'bayarGDS', 'biaya', 'biayaObat', 'tarifObatFlat'))->setPaper($a)->setOrientation('landscape')->setWarnings(false);
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
	public function laporanLabaRugi($bulan, $tahun){
		$lap = new LaporanLabaRugisController;
		$pendapatan_usahas = $lap->tempLaporanLabaRugi($bulan, $tahun)['pendapatan_usahas'];
		$hpps              = $lap->tempLaporanLabaRugi($bulan, $tahun)['hpps'];
		$biayas            = $lap->tempLaporanLabaRugi($bulan, $tahun)['biayas'];
		$pendapatan_lains  = $lap->tempLaporanLabaRugi($bulan, $tahun)['pendapatan_lains'];
		$bulan             = $lap->tempLaporanLabaRugi($bulan, $tahun)['bulan'];
		$tahun             = $lap->tempLaporanLabaRugi($bulan, $tahun)['tahun'];
		$bebans            = $lap->tempLaporanLabaRugi($bulan, $tahun)['bebans'];
		$data = [
            'pendapatan_usahas' => $pendapatan_usahas,
            'hpps' => $hpps,
            'biayas' => $biayas,
            'pendapatan_lains' => $pendapatan_lains,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'bebans' => $bebans
		];
		$pdf = PDF::loadView('pdfs.laporan_laba_rugi', $data)->setPaper('a4');
        return $pdf->stream();
	}
	public function this(){
		$data =  [
			 'foo' => 'bar'
		];
		$pdf = PDF::loadView('pdfs.jurnal_umum', $data)
			->setPaper('a5')
			->setOrientation('landscape')
			->setOption('margin-bottom', 0);
		return $pdf->stream();
	}
	public function laporanNeraca(){

		$th = new LaporanNeracasController;
		
		$akunAktivaLancar      = $th->temp()['akunAktivaLancar'];
		$total_harta           = $th->temp()['total_harta'];
		$akunHutang            = $th->temp()['akunHutang'];
		$akunModal             = $th->temp()['akunModal'];
		$laba_tahun_berjalan   = $th->temp()['laba_tahun_berjalan'];
		$akunAktivaTidakLancar = $th->temp()['akunAktivaTidakLancar'];
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
			->setOption('margin-bottom', 0);
		return $pdf->stream();
	}
	public function jurnalUmum($bulan, $tahun){
		$ju = JurnalUmum::where('created_at', 'like', $tahun . '-' . $bulan . '%')
			->get();
		$jurnals = [];
		foreach ($ju as $j) {
			$jurnals[$j->jurnalable_id.$j->jurnalable_type][] = $j;
		}

		$pdf = PDF::loadView('pdfs.jurnal_umum', compact(
			'jurnals'
		))
			->setPaper('a4')
			->setOption('margin-bottom', 0);
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
	
	
	
	
	
	
    
	
    
    
    
}
