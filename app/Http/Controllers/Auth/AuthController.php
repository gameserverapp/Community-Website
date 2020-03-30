<?php namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth;
use GameserverApp\Api\OAuthApi;
use GameserverApp\Helpers\PremiumHostedHelper;

class AuthController extends Controller
{

    /**
     * @var Guard
     */
    private $guard;
    /**
     * @var OAuthApi
     */
    private $api;

    /**
     * AuthController constructor.
     *
     * @param Guard    $guard
     * @param OAuthApi $api
     */
    public function __construct(
        Guard $guard,
        OAuthApi $api
    ) {
        $this->guard = $guard;
        $this->api = $api;
    }

    public function login()
    {
        return redirect(config('gameserverapp.connection.url') .
            'oauth/authorize?client_id=' . PremiumHostedHelper::clientId() .
            '&redirect_url=' . PremiumHostedHelper::redirectUrl() .
            '&response_type=code');
    }

    public function callback(Request $request)
    {
        if (! $request->has('code')) {
            return redirect(route('auth.login'));
        }

        try {
            $response = $this->api->getAccessTokensWithAuthorizationCode($request->code);
        } catch (ClientException $e) {

            Bugsnag::notifyException($e);

            if($e->getCode() == 400) {
                return redirect(route('auth.login'));
            }

            Auth::logout();
            return redirect('/');
        }

        if ($response->getStatusCode() == 200) {
            $tokens = json_decode($response->getBody()->getContents());

            app(OAuthApi::class)->setTokenCookie($tokens);

            return redirect()->intended();
        }

        return redirect('/');
    }

    public function logout()
    {
        return $this->guard->logout();
    }

    public function restricted()
    {
        return view('errors.restricted');
    }

    public function disabled()
    {
        return view('errors.disabled');
    }

}