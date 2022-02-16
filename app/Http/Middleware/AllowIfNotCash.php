<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Periksa;
use App\Models\CheckoutKasir;
use App\Models\JurnalUmum;
use App\Models\Classes\Yoga;
use Auth;

class AllowIfNotCash
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
        $id      = $request->id;
        $periksa = Periksa::find( $id );


        $checkout = CheckoutKasir::latest()->first();
        $jurnal_id = JurnalUmum::where('jurnalable_type', 'App\Periksa')
                                ->where('jurnalable_id', $periksa->id)
                                ->latest()
                                ->first()
                                ->id;

        $tunaiAdaTapiBolehDiedit = false;

        /* dd( $checkout->jurnal_umum_id, $jurnal_id ); */

        if ( $checkout->jurnal_umum_id > $jurnal_id ) {
            $tunaiAdaTapiBolehDiedit = true;
        }

        if (
            (
                ($periksa->tunai < 1 || $tunaiAdaTapiBolehDiedit) && 
                Auth::user()->role > 3 &&
                $periksa->asuransi_id != '0'
            ) || 
            Auth::id() == '28'
        ) {
            return $next($request);
        } else if ( $periksa->tunai > 0 ) {
            $pesan = Yoga::gagalFlash('Untuk mengedit pemeriksaan ini, kasir harus dikosongkan dahulu oleh dr. Puri, atau hubungi super admin untuk edit sebelum kosongkan kasir');
            return redirect()->back()->withPesan($pesan);
        } else if ( Auth::user()->role > 3 ){
            $pesan = Yoga::gagalFlash('Hanya user dengan akses minimal admin bisa menggunakan fasilitas ini');
            return redirect()->back()->withPesan($pesan);
        }
    }
}
