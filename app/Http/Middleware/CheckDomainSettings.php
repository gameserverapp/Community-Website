<?php

namespace App\Http\Middleware;

use Closure;
use GameserverApp\Api\Client;

class CheckDomainSettings
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
        $domainSettings = Client::domain();

        if(
            $domainSettings instanceof \Exception and
            $domainSettings->getCode() == 404
        ) {

            $response = json_decode($domainSettings->getResponse()->getBody());

            if(isset($response->redirect_url)) {
                return redirect($response->redirect_url);
            }

            return redirect('https://www.gameserverapp.com/');
        }

        return $next($request);
    }
}
