<?php

namespace App\Http\Middleware;

use Closure;

class redirectToApps
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
        if(!empty(session('token'))){
            return redirect()->route('app');
        }
        return $next($request);
    }
}
