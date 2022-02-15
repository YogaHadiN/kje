<?php

namespace App\Http\Middleware;

use Closure;

class SudahSelesaiPeriksa
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
		$selesai = new SudahSelesai;
		$kembali = $selesai->form($request, 'periksa');

		if ($kembali) {
			return $kembali;
		}
        return $next($request);
    }
}
