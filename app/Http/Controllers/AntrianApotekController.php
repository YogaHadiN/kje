<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AntrianApotek;
use App\Models\AntrianPeriksa;
use App\Models\Antrian;
use App\Models\PengantarPasien;
use Input;
use App\Models\Classes\Yoga;
use DB;

class AntrianApotekController extends Controller
{
    public function index(){
        $antrianapoteks = AntrianApotek::with('periksa.pasien', 'periksa.asuransi', 'antrian.jenis_antrian')->get();
        /* dd( $antrianapoteks ); */
        return view('antrianapoteks.index', compact(
            'antrianapoteks'
        ));
    }
    public function kembali($id){
        $antrianapotek = AntrianApotek::with( 'periksa.pasien' )->where('id', $id)->first();
		if (!is_null($antrianapotek)) {

            $periksa = $antrianapotek->periksa;

			$antrian                              = new AntrianPeriksa;
			$antrian->poli_id                     = $periksa->poli_id;
			$antrian->periksa_id                  = $periksa->periksa_id;
			$antrian->staf_id                     = $periksa->staf_id;
			$antrian->asuransi_id                 = $periksa->asuransi_id;
			$antrian->asisten_id                  = $periksa->asisten_id;
			$antrian->pasien_id                   = $periksa->pasien_id;
			$antrian->jam                         = $periksa->jam;
			$antrian->tanggal                     = $periksa->tanggal;
			$antrian->memilih_obat_paten          = $antrianapotek->memilih_obat_paten;
			$antrian->previous_complaint_resolved = $antrianapotek->previous_complaint_resolved;
			$antrian->alergi_obat                 = $antrianapotek->alergi_obat;
			$antrian->save();

			$periksa->antrian_periksa_id = $antrian->id;
			$periksa->save();

			Antrian::where('antriable_id', $antrianapotek->id)
				->where('antriable_type', 'App\Models\AntrianApotek')
				->update([
					'antriable_id'   => $antrian->id,
					'antriable_type' => 'App\Models\AntrianPeriksa'
				]);

			PengantarPasien::where('antarable_id', $antrianapotek->id)
				->where('antarable_type', 'App\ModelsModels\\AntrianApotek')
				->update([
					'antarable_id'   => $antrian->id,
					'antarable_type' => 'App\Models\AntrianPeriksa'
				]);

			$nama = $antrianapotek->periksa->pasien_id . '-' . $antrianapotek->periksa->pasien->nama;
			$antrianapotek->delete();
			$pesan = Yoga::suksesFlash('Pasien <strong>' . $nama . '</strong> Berhasil dikembalikan ke antrian apotek');
			return redirect()->back()->withPesan($pesan);
		} else {
			$pesan = Yoga::gagalFlash('Pasien sudah ada tidak ada di antrian poli ' . $antrian->poli->poli);
			return redirect()->back()->withPesan($pesan);
		}
    }
}
