<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Classes\Yoga;

class Authenticate
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



        if (Auth::guard($guard)->guest()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect('/login')
                ->withInput()
                ->withPesan('Silahkan Login Terlebih Dahulu');
            }
        }

        if (Auth::user()->aktif != '1') {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect('/login')
                ->withInput()
                ->withPesan('Akun Anda Sudah Tidak Aktif, Tanya Super User untuk mengaktifkan!');
            }
        }
       

        return $next($request);
    }
}
