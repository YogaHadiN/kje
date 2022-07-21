<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use App\Models\Periksa;
use App\Models\Asuransi;
use App\Models\Classes\Yoga;
use App\Models\PesertaBpjsPerbulan;
use App\Http\Controllers\LaporansController;
use App\Http\Controllers\PdfsController;
use App\Http\Controllers\PeriksasController;

class CekDanMasukkanProlanis
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
        $pdf        = new PdfsController;
        $periksa_id = $request->id;
        $periksa    = Periksa::find( $periksa_id );
        $pasien     = $periksa->pasien;
        $pc         = new PeriksasController;

        /* dd( */
        /*     $periksa->asuransi->tipe_asuransi_id, */
        /*     $pasien->prolanis_ht, */
        /*     $pasien->prolanis_dm */
        /* ); */
        if (
            $periksa->asuransi->tipe_asuransi_id ==  5 &&//jika pemeriksaan menggunakan pembayaran BPJS
            ($pasien->prolanis_ht || $pasien->prolanis_dm) //jika pasien merupakan pasien prolanis_ht atau dm
        ) {
            if (
                $pasien->prolanis_ht &&//jika pasien merupakan pasien prolanis_ht
                is_null($pasien->prolanis_ht_flagging_image)//jika pasien belum diflagging prolanis hipertensi
            ) {
                $pesan = Yoga::gagalFlash('Pasien ini harus diflagging sebagai Pasien <strong>PROLANIS HIPERTENSI</strong>, harap upload bukti bahwa pasien sudah didaftarkan sebagai pasien prolanis Hipertensi BPJS');
                return redirect('pasiens/' . $pasien->id . '/edit')->withPesan($pesan);
            } else if (
                $pasien->prolanis_dm &&//jika pasien merupakan pasien prolanis_ht
                is_null($pasien->prolanis_dm_flagging_image)//jika pasien belum diflagging prolanis hipertensi
            ){
                $pesan = Yoga::gagalFlash('Pasien ini harus diflagging sebagai Pasien <strong>PROLANIS DIABETES MELITUS</strong>, harap upload bukti bahwa pasien sudah didaftarkan sebagai pasien prolanis DM BPJS');
                return redirect('pasiens/' . $pasien->id . '/edit')->withPesan($pesan);
            }
        }
        return $next($request);
    }
    /**
     * undocumented function
     *
     * @return void
     */
    private function cariPersentaseHtTerkendali($periksa)
    {
        $bulanTahunPeriksa    = Carbon::parse($periksa->tanggal)->format('Y-m');
        $lap                  = new LaporansController;
		$rppt                 = $lap->cariJumlahProlanis(date('Y-m'));
		$jumlah_prolanis_ht   = $rppt['jumlah_prolanis_ht'];
		$status_ht            = $lap->cariStatusHt(date('Y-m'), $jumlah_prolanis_ht);
		return $status_ht['ht_terkendali_persen'];
    }
    
}
