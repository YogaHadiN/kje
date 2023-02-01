<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Asuransi;
use App\Models\AntrianPoli;
use App\Models\Classes\Yoga;

class FilterBpjsDiNurseStation
{
    public function handle(Request $request, Closure $next)
    {
        $asuransi_bpjs_id = Asuransi::Bpjs()->id;
        $antrian_poli_id  = $request->route()->parameters()['id'];
        $antrian_poli     = AntrianPoli::with('pasien')->where('id', $antrian_poli_id)->first();
        $pesanGagal       = [];


        if (is_null( $antrian_poli )) {
            $pesan = Yoga::gagalFlash(
                'Pasien sudah tidak ada lagi di antrian poli'
            );
            return redirect('antrianpolis')->withPesan($pesan);
        } else if (!is_null( $antrian_poli ) && $antrian_poli->asuransi_id == $asuransi_bpjs_id) {
            if ( empty(  $antrian_poli->pasien->nomor_asuransi_bpjs  )   ) {
                $pesanGagal[] = 'nomor asuransi bpjs pasien masih kosong';
            }
            if ( empty(  $antrian_poli->pasien->image  )   ) {
                $pesanGagal[] = 'Foto pasien masih kosong';
            }
            if (
                empty(  $antrian_poli->pasien->ktp_image  )   &&
                umur( $antrian_poli->pasien->tanggal_lahir ) > 17
            ) {
                $pesanGagal[] = 'KTP pasien masih belum difoto';
            }
            if (
                empty(  $antrian_poli->pasien->nomor_ktp  )  &&
                umur( $antrian_poli->pasien->tanggal_lahir ) > 17
            ) {
                $pesanGagal[] = 'Nomor KTP pasien belum diisi';
            }
        }

        $pesan = '<ul>';
        foreach ($pesanGagal as $psn) {
            $pesan .= '<li>';
            $pesan .= $psn;
            $pesan .= '</li>';
        }
        $pesan .= '</ul>';

        if ( count( $pesanGagal ) ) {
            return redirect('pasiens/' . $antrian_poli->pasien_id . '/edit')->withpesan( Yoga::gagalFlash( $pesan ) );
        }
        return $next($request);
    }
}
