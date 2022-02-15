<?php

namespace App\Http\Middleware;

use Closure;
use App\JurnalUmum;
use App\KeteranganPenyusutan;
use App\Http\Controllers\JurnalUmumsController;
use App\Classes\Yoga;
use DB;

class NotReady
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
		$route_coa = $request->path();
		if ($this->jurnalNull($route_coa)) {
			return $this->jurnalNull($route_coa);
		}
		if ($this->konfirmasiBahanBangunan($route_coa)) {
			return $this->konfirmasiBahanBangunan($route_coa);
		}
		if ($this->konfirmasiRenovasiSelesai($route_coa)) {
			return $this->konfirmasiRenovasiSelesai($route_coa);
		}
		if ($this->konfirmasiPeralatan($route_coa)) {
			return $this->konfirmasiPeralatan($route_coa);
		}
		if ($this->konfirmasiServiceAc($route_coa)) {
			return $this->konfirmasiServiceAc($route_coa);
		}

        return $next($request);
    }

	public function jurnalNull($route_coa){
		$jurnalNull = JurnalUmum::whereNull('coa_id')
								->count();
		if ($jurnalNull){
			session([ 'route_coa' => $route_coa]); // session ini gak berhasil direkam
			$pesan = 'Ada beberapa Chart Of Account yang harus disesuaikan dulu';
			return redirect('jurnal_umums/coa') // session yang ini juga gak berhasil direkam, kenapa ya?`R`
				->withPesan(Yoga::infoFlash($pesan));
		}
	}
	public function konfirmasiRenovasiSelesai($route_coa){
		$bulanIni  = date('Y-m') . '-01';
		$jur       = new JurnalUmumsController;
		$datas     = $jur->queryRenovasiBulanIni($bulanIni);
		$countNull = $datas[0]->jumlah;
		if ($countNull) {
			session([ 'route_coa' => $route_coa]);
			$pesan = Yoga::infoFlash('Konfirmasikan Dulu apakah renovasi sudah selesai?'); 
			return redirect('bahan_bangunans/konfirmasi/' . date('m') . '/' . date('Y'))->withPesan($pesan);
		}
	}
	public function konfirmasiBahanBangunan($route_coa){
		$datas = JurnalUmum::where('coa_id', '120010')->where('jurnalable_type', 'App\Pengeluaran')->count();
		if ($datas) {
			session([ 'route_coa' => $route_coa]);
			$pesan = Yoga::infoFlash('Mohon Ikhstisarkan dulu Bahan Bangunan yang dibeli'); 
			return redirect('bahan_bangunans/ikhtisarkan')->withPesan($pesan);
		}
	}
	public function konfirmasiServiceAc($route_coa){
		$jur = new JurnalUmumsController;
		$datas = $jur->queryKonfirmasiServiceAc($route_coa);
		if (count($datas)) {
			session([ 'route_coa' => $route_coa]);
			$pesan = Yoga::infoFlash('Mohon Jelaskan dulu Service Ac yang sudah dilakukan'); 
			return redirect('service_ac/konfirmasi')->withPesan($pesan);
		}
	}
	public function konfirmasiPeralatan($route_coa){
		$jur = new JurnalUmumsController;
		$datas = $jur->queryKonfirmasiPeralatan();
		if ( count($datas) > 0 ) {
			session([ 'route_coa' => $route_coa]);
			$pesan = Yoga::infoFlash('Mohon Jelaskan dulu Belanja Peralatan yang sudah dibeli'); 
			return redirect('peralatans/konfirmasi')->withPesan($pesan);
		}
	}
}

