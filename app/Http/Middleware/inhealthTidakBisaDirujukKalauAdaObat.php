<?php

namespace App\Http\Middleware;

use Closure;
use Input;
use App\Models\Periksa;
use App\Models\Rujukan;
use App\Models\Classes\Yoga;

class inhealthTidakBisaDirujukKalauAdaObat
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
        $id = $request->route()->parameter('id'); 
        if (is_null($id)) {
            $id = $request->id;
        }
        if (is_null($id)) {
            $id = $request->periksa_id;
        }
        if (
             str_contains($request->fullUrl(), 'edit') ||
             $request->method() == 'PUT'
        ) {
            $periksa = Rujukan::find($id)->periksa;
        } else {
            $periksa = Periksa::find( $id );
        }
        if ( 
            $periksa->terapi !== '[]'  &&
            $periksa->asuransi_id == '3'
        ) {
            $pesan = Yoga::gagalFlash('Maaf, untuk peserta inhealth tidak bisa dirujuk apabila ada terapi. Mohon untuk bisa hapus terapi pasien apabila ingin melanjutkan merujuk pasien');
            return redirect()->back()->withPesan($pesan);
        }

        return $next($request);
    }
}
