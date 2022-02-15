<?php

namespace App\Http\Middleware;

use Closure;
use App\Http\Controllers\AntrianPolisController;
use App\Periksa;
use App\Classes\Yoga;
use App\AntrianPeriksa;

class harusUrutDiPoliUmum
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
		$id                       = $request->id;
		$apl                      = new AntrianPolisController;
		$ap                       = AntrianPeriksa::with('pasien.alergies')->where('id',$id)->first();
		$request->antrian_periksa = $ap;

		return $next($request);
		$periksa = Periksa::where('tanggal', $ap->tanggal)->where('antrian', $ap->antrian)->first();

		
		if (
			!( $ap->poli == 'umum' || $ap->poli == 'luka' || $ap->poli == 'sks') || 
			(( $ap->poli == 'umum' || $ap->poli == 'luka' || $ap->poli == 'sks') && !is_null($periksa))
		) {
			return $next($request);
		}
		// nomor antrian_yang_ditulis_admin 

		$totalAntrian       = $apl->totalAntrian($ap);
		// antrian_view yang seharusnya diperiksa saat ini 
		$antrian_saat_ini   = $totalAntrian['antrian_saat_ini'];

		$antrians = $totalAntrian['antrians'];

		$antrian = $antrians[$antrian_saat_ini];

		$apx= AntrianPeriksa::where('antrian', $antrian)->where('tanggal', $ap->tanggal)->first();

		$valid = true;
		if ( !$antrian == $ap->antrian) {
			$valid    = false;
			$message  = 'Nomor antrian tidak urut, harusnya antrian selanjutnya adalah <strong>' . $apx->pasien_id . '-' . $apx->pasien->nama . '</strong>';
			$message .= '<br />Jika anda ingin memeriksa pasien ini tanpa mengikuti antrian, ganti poli pasien ini menjadi poli gawat darurat';
			$pesan    = Yoga::gagalFlash($message);
		} 

		if (!( $ap->antrian == '1'&& $antrian_saat_ini == '0')) {
			$valid   = false;
			$message = 'Pasien bukan nomor antrian pertama, ganti ke poli gawat darurat jika Anda tetap ingin memeriksa pasien ini';
			$pesan   = Yoga::gagalFlash($message);
		} 

		if ($valid) {
			return $next($request);
		} else {
			return redirect()->back()->withPesan($pesan);
		}
    }
}
