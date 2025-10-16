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
        if(auth()->check()) {

            $user = auth()->user();

            if(!$user->hasRuleGates()) {
                return $next($request);
            }

            $excluded = [
                route('auth.logout'),
                $request->root() . '/user/me/accept_rules/*',
            ];

            $ruleGates = $user->ruleGates();

            $ruleGateUrls = [];

            foreach($ruleGates as $ruleGate) {
                $excluded[] = route('user.accept_rules', [
                    'access_group_id' => $ruleGate->group_id
                ]);

                $excluded[] = $ruleGate->route;

                $ruleGateUrls[] = $ruleGate->route;
            }

            if(!in_array($request->url(), $excluded)) {
                return redirect($ruleGateUrls[0]);
            }
        }

        return $next($request);
    }
}
