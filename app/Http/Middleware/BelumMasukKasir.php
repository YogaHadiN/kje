<?php

namespace App\Http\Middleware;

use Closure;
use App\Periksa;
use App\AntrianPeriksa;
use App\Classes\Yoga;

class BelumMasukKasir
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
		$periksa_id =  $request->route()->parameter('id') ;
		$periksa = Periksa::find($periksa_id);
		$request->merge(array("periksa" => $periksa));
		if ( is_null($periksa) ) {
			$pesan = Yoga::gagalFlash('Pasien tidak ditemukan');
		}
		if ( !is_null(AntrianPeriksa::where('periksa_id', $periksa_id)->first()) ) {
			$pesan = Yoga::gagalFlash('Pasien sudah ada di antrian periksa, tidak perlu dikembalikan lagi');
		}
		if (isset($pesan)) {
			return redirect()->back()->withPesan($pesan);
		}
		return $next($request);

    }
}
