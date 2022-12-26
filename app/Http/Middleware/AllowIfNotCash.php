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
        if (is_null($periksa)) {
            $pesan = Yoga::gagalFlash('Data pemeriksaan yang dimaksud tidak ditemukan');
            return redirect()->back()->withPesan($pesan);
        }

        $checkout = CheckoutKasir::latest()->first();
        $jurnal = JurnalUmum::where('jurnalable_type', 'App\Models\Periksa')
                            ->where('jurnalable_id', $periksa->id)
                            ->latest()
                            ->first();
        if (is_null($jurnal)) {
            $pesan = Yoga::gagalFlash('Data pemeriksaan belum bisa diedit. Silahkan selesaikan dulu hingga kasir');
            return redirect()->back()->withPesan($pesan);
        }

        $jurnal_id = $jurnal->id;

        $tunaiAdaTapiBolehDiedit = false;
        

        $jurnal_umum_id = !is_null($checkout) ? $checkout->jurnal_umum_id : 0; 
        if ( $jurnal_umum_id > $jurnal_id ) {
            $tunaiAdaTapiBolehDiedit = true;
        }

        if (
            (
                ($periksa->tunai < 1 || $tunaiAdaTapiBolehDiedit) && 
                Auth::user()->role_id > 3 &&
                $periksa->asuransi_id != '0'
            ) || 
            Auth::id() == '28'
        ) {
            return $next($request);
        } else if ( $periksa->tunai > 0 ) {
            $pesan = Yoga::gagalFlash('Untuk mengedit pemeriksaan ini, kasir harus dikosongkan dahulu oleh dr. Puri, atau hubungi super admin untuk edit sebelum kosongkan kasir');
            return redirect()->back()->withPesan($pesan);
        } else if ( Auth::user()->role_id > 3 ){
            $pesan = Yoga::gagalFlash('Hanya user dengan akses minimal admin bisa menggunakan fasilitas ini');
            return redirect()->back()->withPesan($pesan);
        }
    }
}
