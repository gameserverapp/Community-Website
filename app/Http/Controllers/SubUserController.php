<?php namespace App\Http\Controllers;

use Dompdf\Dompdf;
use GameserverApp\Helpers\SiteHelper;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use GameserverApp\Api\Client;
use GameserverApp\Api\OAuthApi;
use GameserverApp\Models\Character;
use Illuminate\Support\Facades\Cookie;

class SubUserController extends Controller
{
    private $api;
    
    public function __construct()
    {
        $this->api = app(Client::class);
    }

    public function connect(Request $request)
    {
        $this->validate($request, [
            'code' => 'required|string'
        ]);

        try {
            $response = $this->api->connectSubUser(
                $request->input('code')
            );
        } catch (ClientException $e) {
            return Client::exceptionToAlert($e);
        }

        app(OAuthApi::class)->clearCache(
            'get',
            'user/me',
            OauthApi::requestOriginInfo(),
            true
        );

        if(isset($response->data)) {
            return redirectBackWithAlert($response->data);
        }

        return redirectBackWithAlert('Something went wrong. Please try again or contact support', 'danger');

    }

    public function disconnect($subUuid)
    {
        try {
            $response = $this->api->disconnectSubUser($subUuid);
        } catch (ClientException $e) {
            return Client::exceptionToAlert($e);
        }

        app(OAuthApi::class)->clearCache(
            'get',
            'user/me',
            OauthApi::requestOriginInfo(),
            true
        );

        if(isset($response->data)) {
            return redirectBackWithAlert($response->data);
        }

        return redirectBackWithAlert('Something went wrong. Please try again or contact support', 'danger');
    }
}