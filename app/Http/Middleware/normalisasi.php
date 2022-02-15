<?php

namespace App\Http\Middleware;

use Closure;

class normalisasi
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
		$nr = new NotReady;
		$route_coa = $request->path();
		if ($nr->konfirmasiRenovasiSelesai($route_coa)) {
			return $nr->konfirmasiRenovasiSelesai($route_coa);
		}
		if ($nr->konfirmasiPeralatan($route_coa)) {
			return $nr->konfirmasiPeralatan($route_coa);
		}
		if ($nr->konfirmasiServiceAc($route_coa)) {
			return $nr->konfirmasiServiceAc($route_coa);
		}
        return $next($request);
    }

}
