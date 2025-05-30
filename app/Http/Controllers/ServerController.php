<?php namespace App\Http\Controllers;


use App\Http\Controllers\Forum\CategoryController;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use GameserverApp\Api\Client;
use GameserverApp\Api\OAuthApi;
use GameserverApp\Helpers\RouteHelper;
use GameserverApp\Models\Character;
use GameserverApp\Models\Server;

class ServerController extends Controller
{
    /**
     * @var Client
     */
    private $api;

    /**
     * HomeController constructor.
     *
     * @param Client $api
     */
    public function __construct()
    {
        $this->api = app(Client::class);
    }

    public function show(Request $request, $id)
    {
        $server = $this->api->server($id);

        if(!$server) {
            return response('Could not retrieve data', 500);
        }

        return view('partials.v3.server', [
            'server' => $server,
            'status' => true
        ]);
    }

    public function claimVote(Request $request, $id)
    {
        try {
            $response = $this->api->serverClaimVote($id);
        } catch (ClientException $e) {
            return Client::exceptionToAlert($e);
        }

        return redirectBackWithAlert('Something went wrong. Please try again in a moment', 'danger');
    }
}