<?php

namespace App\Http\Controllers;

use Input;

use App\Http\Requests;

use App\Models\Periksa;
use App\Models\Antrian;
use App\Models\Classes\Yoga;
use App\Models\AntrianKasir;
use App\Models\AntrianApotek;
use App\Models\PengantarPasien;

class AntrianKasirsController extends Controller
{

	/**
	 * Display a listing of antriankasirs
	 *
	 * @return Response
	 */
	public function index()
	{
		$antriankasirs = AntrianKasir::with('periksa.pasien', 'periksa.asuransi', 'antrian.jenis_antrian')->get();
		/* dd($antriankasirs->first()->transaksi); */
		return view('antriankasirs.index', compact('antriankasirs'));
	}
	public function kembali($id){
		$antriankasir = AntrianKasir::with('periksa.pasien')->where('id', $id)->first();
		if (!AntrianApotek::where('periksa_id', $antriankasir->periksa_id)->exists() ) {

			$antrianapotek             = new AntrianApotek;
			$antrianapotek->periksa_id = $antriankasir->periksa_id;
			$antrianapotek->jam        = date('H:i:s');
			$antrianapotek->tanggal    = date('Y-m-d');
			$antrianapotek->save();

			Antrian::where('antriable_id', $antriankasir->id)
				->where('antriable_type', 'App\Models\AntrianKasir')
				->update([
					'antriable_id'   => $antrianapotek->id,
					'antriable_type' => 'App\Models\AntrianApotek'
				]);
			PengantarPasien::where('antarable_id', $antriankasir->id)
				->where('antarable_type', 'App\Models\AntrianKasir')
				->update([
					'antarable_id'   => $antrianapotek->id,
					'antarable_type' => 'App\Models\AntrianApotek'
				]);

			$nama  = $antriankasir->periksa->pasien_id . '-' . $antriankasir->periksa->pasien->nama;
			$antriankasir->delete();
			$pesan = Yoga::suksesFlash('Pasien <strong>' . $nama . '</strong> Berhasil dikembalikan ke antrian apotek');
			return redirect()->back()->withPesan($pesan);
		} else {
			$pesan = Yoga::gagalFlash('Pasien sudah ada di antrian apotek');
			return redirect()->back()->withPesan($pesan);
		}
	}
}
