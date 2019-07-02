<?php

namespace App\Http\Middleware;

use Closure;

class Dispecer
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
        if(!auth()->user()->isDispecer()){
            return redirect('/rezervari');
        }
        return $next($request);
    }
}
