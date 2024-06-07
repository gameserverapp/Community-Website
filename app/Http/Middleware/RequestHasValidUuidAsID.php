<?php

namespace App\Http\Middleware;

use App\Exceptions\DomainNotFoundException;
use Closure;
use GameserverApp\Api\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class RequestHasValidUuidAsID
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
    public function handle(Request $request, Closure $next, $guard = null)
    {
        if(
            $id = $request->route('id') or
            $id = $request->route('uuid')
        ) {
            if($id === 'me') {
                return $next($request);
            }

            $validator = Validator::make(
                [
                    'request_id' => $id
                ],
                [
                    'request_id' => 'uuid'
                ]
            );

            if(!$validator->fails()) {
                return $next($request);
            }
        }

        throw new BadRequestHttpException('Invalid ID format');
    }
}
