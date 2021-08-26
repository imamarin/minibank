<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class StatusLoginNasabah
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
        if (!($request->session()->has('username'))) {
            return redirect('logout');
        }else{
            if($request->session()->get('idlevel')=='nsb'){
                return $next($request);
            }else{
                return redirect('logout');
            }
        }
    }
}
