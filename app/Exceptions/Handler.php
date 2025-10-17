<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Foundation\Http\Exceptions\MaintenanceModeException;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\HttpFoundation\Exception\SuspiciousOperationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
        MaintenanceModeException::class,
        SuspiciousOperationException::class
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        if($e instanceof DomainNotFoundException) {
            return redirect(config('gameserverapp.main_site'));
        }

        if($e instanceof BackendErrorException) {
            return response()->view('errors.backend-error', [], 500);
        }

        if ($this->isHttpException($e)) {
            return $this->renderHttpException($e);
        }

//        if (!config('app.debug')) {
//
//            if($e instanceof AuthenticationException) {
//                return response()->view('errors.restricted', [], 401);
//            }
//
//            if(!in_array($e, $this->dontReport)) {
//                return response()->view('errors.500', [], 500);
//            }
//        }

        return parent::render($request, $e);
    }
    
    protected function convertExceptionToResponse(Exception $e)
    {
//        if (config('app.debug')) {
//            $whoops = new \Whoops\Run;
//            $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
//
//            return response()->make(
//                $whoops->handleException($e),
//                method_exists($e, 'getStatusCode') ? $e->getStatusCode() : 500,
//                method_exists($e, 'getHeaders') ? $e->getHeaders() : []
//            );
//        }

        return parent::convertExceptionToResponse($e);
    }

    protected function prepareException(Exception $e)
    {
        if ($e instanceof SuspiciousOperationException) {
            $e = new NotFoundHttpException(null, $e);
        }

        return parent::prepareException($e);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return redirect()->guest(route('auth.restricted'));
    }
}
