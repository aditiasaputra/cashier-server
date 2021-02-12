<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class StripAuthenticateHeader
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
        header_remove('X-Powered-By');
        return $next($request);
    }
}
