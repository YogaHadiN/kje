<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class ExtendSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
   public function handle($request, $next)
    {

        $lifetime = 2;
        config(['session.lifetime' => $lifetime]);
        return $next($request);
    }
}
