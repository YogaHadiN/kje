<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use App\AntrianPoli;
use App\AntrianPeriksa;
use App\Periksa;
use App\Classes\Yoga;

class nomorAntrianUnik
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
		$tanggal = date('Y-m-d');
		if (isset( $request->tanggal )) {
			$tanggal = $request->tanggal;
			$tanggal = Carbon::CreateFromFormat('d-m-Y',$request->tanggal)->format('Y-m-d');
		}
		$nomor_antrian = $request->antrian;

		$apx_per_tanggal = AntrianPeriksa::where('tanggal', $tanggal )
			->where('antrian', $nomor_antrian)
			->first();
		$apl_per_tanggal = AntrianPoli::where('tanggal', $tanggal )
			->where('antrian', $nomor_antrian)
			->first();
		$px_per_tanggal = Periksa::where('tanggal', $tanggal )
			->where('antrian', $nomor_antrian)
			->first();
		$nama_pasien;
		if (
			is_null($apx_per_tanggal) &&
			is_null($apl_per_tanggal) &&
			is_null($px_per_tanggal)
		) {
			return $next($request);
		} else {
			if (!is_null($apx_per_tanggal)) {
				$nama_pasien = $apx_per_tanggal->pasien->nama;
			}else if (!is_null($apl_per_tanggal)) {
				$nama_pasien = $apl_per_tanggal->pasien->nama;
			}else if (!is_null($px_per_tanggal)) {
				$nama_pasien = $px_per_tanggal->pasien->nama;
			}
		}
		$pesan = Yoga::gagalFlash('Nomor antrian ' . $nomor_antrian . ' sudah terpakai oleh pasien bernama ' . $nama_pasien .' Mohon gunakan nomor yang lain');
		return redirect()->back()->withPesan($pesan);
    }
}
