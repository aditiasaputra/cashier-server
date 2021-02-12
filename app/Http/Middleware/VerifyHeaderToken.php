<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerifyHeaderToken
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
        // Authrization bearer token
        $authorization = $request->header('Authorization');
        $token = explode(' ', $authorization);
        $authToken = end($token);

        // Cookie token
        $cookieToken = $request->cookie('token');

        // Check auth token & cookie token if not same
        if ($authToken !== $cookieToken) {
            return response()->json(['message' => 'Something\'s wrong!'], 401);
        }

        return $next($request);
    }
}
