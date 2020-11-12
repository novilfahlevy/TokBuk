<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $posisi = array_slice(func_get_args(), 2);
        $posisiUser = Auth::user()->posisi;

        if ( in_array($posisiUser, $posisi) ) {
            return $next($request);
        }

        abort(403);
    }
}
