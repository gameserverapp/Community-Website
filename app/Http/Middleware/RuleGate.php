<?php

namespace App\Http\Middleware;

use Closure;
use GameserverApp\Api\Client;
use GameserverApp\Helpers\RouteHelper;

class RuleGate
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
//        if(auth()->check()) {
//            $rulesRoute = RouteHelper::rules();
//
//            $excluded = [
//                route('auth.logout'),
//                route('user.accept_rules', auth()->user()->id),
//                $rulesRoute
//            ];
//
//
//            if(
//                Client::domain('rulegate', false)and
//                !auth()->user()->acceptedRules() and
//                !in_array($request->url(), $excluded)
//            ) {
//                return redirect($rulesRoute);
//            }
//        }

        return $next($request);
    }
}
