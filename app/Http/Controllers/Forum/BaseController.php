<?php namespace App\Http\Controllers\Forum;

use Forum;
use GuzzleHttp\Psr7\Response;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Exception\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Routing\Controller;
use Illuminate\Support\Collection;
use GameserverApp\Api\Forum\Dispatcher;
use GameserverApp\Api\Forum\ReceiverContract;
use Riari\Forum\Models\Category;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

abstract class BaseController extends Controller implements ReceiverContract
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * @var Dispatcher
     */
    protected $dispatcher;

    /**
     * Create a frontend controller instance.
     */
    public function __construct()
    {
        $this->dispatcher = new Dispatcher($this);
    }

    /**
     * Return a prepared API dispatcher instance.
     *
     * @param  string  $route
     * @param  array  $parameters
     * @return Dispatcher
     */
    protected function api($route, $parameters = [])
    {
        $prefix = config('forum.routing.as');

        return $this->dispatcher->route("{$prefix}api.{$route}", $parameters);
    }

    public function handleResponse(Request $request, Response $response)
    {
        if(!is_numeric($response->getStatusCode())) {
            abort(500);
        }

        switch($response->getStatusCode()) {

            case 500:
                $errors = 'Whoops, something went wrong: ' . $response->getReasonPhrase();

                throw new \Illuminate\Http\Exceptions\HttpResponseException(
                    redirect()->back()->withInput($request->input())->withErrors($errors)
                );

            case 422:
                $errors = json_decode($response->getBody());

                if(isset($errors->errors)) {
                    $errors = $errors->errors;
                }

                throw new \Illuminate\Http\Exceptions\HttpResponseException(
                    redirect()->back()->withErrors($errors)
                );

            case 404:
                abort(404);
                break;

            case 403:
                throw new NotFoundHttpException();

            case 200:
                return json_decode($response->getBody());

            default:
                abort(500);
                break;
        }
    }

    /**
     * Helper: Bulk action response.
     *
     * @param  Collection  $models
     * @param  string  $transKey
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function bulkActionResponse(Collection $models, $transKey)
    {
        if ($models->count()) {
            Forum::alert('success', $transKey, $models->count());
        } else {
            Forum::alert('warning', 'general.invalid_selection');
        }

        return redirect()->back();
    }
}
