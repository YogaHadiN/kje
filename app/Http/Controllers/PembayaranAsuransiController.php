<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Classes\Yoga;
use App\Models\PembayaranAsuransi;
use App\Console\Commands\testcommand;
use DB;

class PembayaranAsuransiController extends Controller
{
	public function index(){
		$query  = "SELECT ";
		$query .= "*, sum(peas.pembayaran) as total_pembayaran ";
		$query .= "FROM pembayaran_asuransis as peas ";
		$query .= "WHERE peas.tenant_id = " . session()->get('tenant_id') . " ";
		$query .= "GROUP BY YEAR(peas.tanggal_dibayar) DESC, MONTH(peas.tanggal_dibayar) DESC";
		$pembayaran_asuransis  = DB::select($query);
		return view('pembayaran_asuransis.index', compact(
			'pembayaran_asuransis'
		));
	}

	public function show($id){

		$query  = "SELECT ";
		$query .= "pd.id as piutang_dibayar_id, ";
		$query .= "px.created_at as tanggal, ";
		$query .= "px.piutang as piutang, ";
		$query .= "ps.nama as nama_pasien, ";
		$query .= "ps.id as pasien_id, ";
		$query .= "pd.pembayaran as pembayaran, ";
		$query .= "px.id as periksa_id ";
		$query .= "FROM pembayaran_asuransis as peas ";
		$query .= "JOIN piutang_dibayars as pd on pd.pembayaran_asuransi_id = peas.id ";
		$query .= "JOIN periksas as px on px.id = pd.periksa_id ";
		$query .= "JOIN pasiens as ps on ps.id = px.pasien_id ";
		$query .= "WHERE peas.id = '{$id}' ";
		$query .= "AND peas.tenant_id = " . session()->get('tenant_id') . " ";

		$pembayaran_asuransi = DB::select($query);

		$total_pembayaran   = 0;
		$total_piutang            = 0;
		$total_sisa_piutang = 0;

		foreach ($pembayaran_asuransi as $pe) {
			$total_pembayaran   += $pe->pembayaran;
			$total_piutang      += $pe->piutang;
			$total_sisa_piutang += $pe->piutang - $pe->pembayaran;
		}

		$pembayaran = PembayaranAsuransi::find( $id );

		return view('pembayaran_asuransis.show', compact(
			'pembayaran_asuransi',
			'pembayaran',
			"total_piutang",
			"total_sisa_piutang",
			"total_pembayaran"
		));
	}
	public function destroy($id){
		$testCommand             = new TestCommand;
		$pembayaran_asuransi_ids = [$id];
		$testCommand->resetPembayaranAsuransis( $pembayaran_asuransi_ids );
		$pesan = Yoga::suksesFlash('Pembayaran Asuransi ' . $id . ' Berhasil dihapus');
		return redirect('pendapatans/pembayaran/asuransi')->withPesan($pesan);
	}
	
	public function perBulan($bulan, $tahun){

		$pembayaran_asuransis = PembayaranAsuransi::with('asuransi', 'coa')
													->where('tanggal_dibayar', 'like', $tahun . '-' . $bulan . '%')
													->orderBy('tanggal_dibayar', 'asc')
													->get();

		return view('pembayaran_asuransis.perBulan', compact(
			'bulan',
			'tahun',
			'pembayaran_asuransis'
		));
		
	}
	
}
