<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\Classes\Yoga;

class adminOnly
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
		if (
			!( Auth::user()->role >= '4')
		) {
			 $pesan = Yoga::gagalFlash( 'Anda tidak diizinkan melakukan operasi ini');
			 return redirect()->back()->withPesan($pesan);
        } 
        return $next($request);
    }
}
