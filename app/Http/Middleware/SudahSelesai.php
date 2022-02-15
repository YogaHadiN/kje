<?php

namespace App\Http\Middleware;

use Closure;
use App\Classes\Yoga;
use App\Periksa;
use App\AntrianPeriksa;

class SudahSelesai
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
		$kembali = $this->form($request, 'id');
		if ($kembali) {
			return $kembali;
		}
        return $next($request);
    }
	public function form($request, $id){
		$periksa_id =  $request->route()->parameters()[$id];
		$periksa = Periksa::find($periksa_id);
		if ($periksa->lewat_kasir2 == 1) {
			AntrianPeriksa::destroy($periksa->antrian_periksa_id);
			$pesan = Yoga::gagalFlash('Pasien sudah pulang, tidak bisa diedit lagi');
			return redirect()->back()->withPesan($pesan);
		}
		return false;
	}
}
