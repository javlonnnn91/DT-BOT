<?php

namespace App\Http\Middleware;

use Closure;

class BasicAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next): mixed
    {
        if ($request->getUser() == env('API_LOGIN', '') && $request->getPassword() == env('API_PASSWORD', '')) {
            return $next($request);
        }

        return response('You shall not pass!', 401, ['WWW-Authenticate' => 'Basic']);
    }
}

