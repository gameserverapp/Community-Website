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

        $response = $this->api->connectSubUser(
            $request->input('code')
        );

        if($response instanceof ClientException) {
            $error = json_decode($response->getResponse()->getBody());
            return redirectBackWithAlert($error->message, 'danger');
        }

        app(OAuthApi::class)->clearCache(
            'get',
            'user/me',
            [
                'url' => base64_encode(request()->getHost())
            ],
            true
        );

        if(isset($response->data)) {
            return redirectBackWithAlert($response->data);
        }

        return redirectBackWithAlert('Something went wrong. Please try again or contact support', 'danger');

    }

    public function disconnect($subUuid)
    {
        $response = $this->api->disconnectSubUser($subUuid);

        app(OAuthApi::class)->clearCache(
            'get',
            'user/me',
            [
                'url' => base64_encode(request()->getHost())
            ],
            true
        );

        if(isset($response->data)) {
            return redirectBackWithAlert($response->data);
        }

        if($response instanceof ClientException) {
            $error = json_decode($response->getResponse()->getBody());

            if(isset($error->message)) {
                return redirectBackWithAlert($error->message, 'danger');
            }
        }

        return redirectBackWithAlert('Something went wrong. Please try again or contact support', 'danger');
    }
}