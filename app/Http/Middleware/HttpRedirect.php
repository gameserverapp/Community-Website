<?php

namespace App\Http\Middleware;

use App\Exceptions\DomainNotFoundException;
use Closure;
use GameserverApp\Api\Client;

class HttpRedirect
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @param  string|null              $guard
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if(
            $request->secure() or
            substr($request->path(), 0, 6) == 'verify'
        ) {
            return $next($request);
        }

        return redirect()->secure($request->getRequestUri());
    }
}
