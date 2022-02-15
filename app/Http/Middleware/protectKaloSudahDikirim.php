<?php

namespace App\Http\Middleware;

use Closure;
use App\KirimBerkas;
use App\Classes\Yoga;
use App\Http\Controllers\KirimBerkasController;


class protectKaloSudahDikirim
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
		$kirimBerkas  = new KirimBerkasController;
		$id           = $kirimBerkas->controllerId($request->id);
		$kirim_berkas = KirimBerkas::find($id);
		if ( !is_null( $kirim_berkas->pengeluaran_id )  ) {
			$pesan = Yoga::gagalFlash('Berkas yang sudah dikirim TIDAK DAPAT DIUBAH MAUPUN DIHAPUS');
			return redirect()->back()->withPesan($pesan);
		}
        return $next($request);
    }
}
