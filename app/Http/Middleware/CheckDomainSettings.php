<?php

namespace App\Http\Middleware;

use App\Exceptions\DomainNotFoundException;
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
        try {
            $domainSettings = Client::domain();
        } catch(DomainNotFoundException $e) {
            $response = json_decode($e->getResponse()->getBody());

            if(isset($response->redirect_url)) {
                return redirect($response->redirect_url);
            }

            return redirect(config('gameserverapp.main_site'));
        }

        if(
            $domainSettings instanceof \Exception and
            $domainSettings->getCode() == 404
        ) {

            $response = json_decode($domainSettings->getResponse()->getBody());


            if(isset($response->redirect_url)) {
                return redirect($response->redirect_url);
            }

            return redirect(config('gameserverapp.main_site'));
        }

        return $next($request);
    }
}
