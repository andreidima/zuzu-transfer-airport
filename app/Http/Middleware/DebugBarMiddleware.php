<?php

namespace App\Http\Middleware;

use Closure;

class DebugBarMiddleware
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
        // if (auth()->user() && in_array(auth()->id(), [355,0])) {
        //     \Debugbar::enable();
        // }
        // else {
        //     \Debugbar::disable();
        // }
        \Debugbar::disable();

        

        return $next($request);
    }
}
