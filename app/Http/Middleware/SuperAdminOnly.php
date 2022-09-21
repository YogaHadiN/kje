<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\Classes\Yoga;

class SuperAdminOnly
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
         if (!(Auth::id() == '28' || Auth::id() == '3003' || Auth::id() == '3010' || Auth::user()->role_id > 3 )) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                $pesan = Yoga::gagalFlash('Anda tidak memiliki hak akses');
                return redirect()->back()->withPesan($pesan);
            }
        } 
        return $next($request);
    }
}
