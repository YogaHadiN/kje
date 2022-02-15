<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\Classes\Yoga;

class KeuanganAccessOnly
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
         if (Auth::user()->role < 5 ) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
				$pesan = Yoga::gagalFlash('Anda tidak memiliki akses untuk melihat data-data keuangan');
				return redirect()->back()->withPesan($pesan);
            }
        } 
        return $next($request);
    }
}
