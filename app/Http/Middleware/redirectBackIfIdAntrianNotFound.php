<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Antrian;
use App\Models\Classes\Yoga;

class redirectBackIfIdAntrianNotFound
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
		try {
			Antrian::findOrFail($request->id);
		} catch (\Exception $e) {
			$pesan = Yoga::gagalFlash('Nomor Antrian Tidak Ditemukan');
			return redirect('antrians')->withPesan($pesan);
		}
        return $next($request);
    }
}
