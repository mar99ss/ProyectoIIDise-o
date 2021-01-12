<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckMovimientoSession
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
        if (!$request->session()->has('movimiento') && !array_key_exists("movimiento", $request->route()->parameters()))
            return redirect(route('movimientos.index'));
        return $next($request);
    }
}
