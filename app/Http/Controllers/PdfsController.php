<?php


namespace App\Http\Controllers;

use Input;

use App\Http\Requests;
use App\Classes\Yoga;
use App\Periksa;
use App\Tarif;
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
		header ('Content-type: text/html; charset=utf-8');
		$periksa    = Periksa::find($periksa_id);
		//cek apakah pasien ini sudah pernah periksa GDS sebelumnya
		//
		//
		$tarifObatFlat = Tarif::where('asuransi_id', $periksa->asuransi_id)->where('jenis_tarif_id', '9')->first()->biaya;		


		$bayarGDS   = false;
		$transaksi_before = json_decode($periksa->transaksi, true);
		// return 'oke';
		if ($periksa->asuransi_id == 32) {
			foreach ($transaksi_before as $key => $value) {
				if (($value['jenis_tarif_id'] == '116')) {
					$bayarGDS = Yoga::cekGDSBulanIni($periksa->pasien_id)['bayar'];
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

        $pdf = PDF::loadView('pdfs.status', compact('periksa', 'cetak_usg', 'puyerAdd', 'bayarGDS', 'biaya', 'biayaObat', 'tarifObatFlat'))->setPaper('a5')->setOrientation('landscape')->setWarnings(false);
        // return view('pdfs.status', compact('periksa', 'cetak_usg', 'puyerAdd', 'bayarGDS'));
        return $pdf->stream();
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



	
}