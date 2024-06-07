<?php

namespace App\Http\Middleware;

use App\Exceptions\DomainNotFoundException;
use Closure;
use GameserverApp\Api\Client;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class RequestHasValidIdWithSlug
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
        if($id = $request->route('id')) {
            $validator = Validator::make(
                [
                    'request_id' => $id
                ],
                [
                    'request_id' => 'numeric'
                ]
            );

            if(!$validator->fails()) {
                return $next($request);
            }
        }

        throw new BadRequestHttpException('Invalid ID format');
    }
}
