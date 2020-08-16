<?php namespace App\Http\Controllers;


use App\Http\Controllers\Forum\CategoryController;
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

        return view('pages.v1.partials.server', [
            'server' => $server
        ]);
    }
}