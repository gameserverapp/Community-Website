<?php namespace App\Http\Controllers;


use Illuminate\Http\Request;
use GameserverApp\Api\Client;
use GameserverApp\Helpers\SiteHelper;

class InspectorController extends Controller
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

    public function index(Request $request)
    {
        if(! SiteHelper::featureEnabled('inspector')) {
            return view('pages.v3.inspector.disabled');
        }

        $servers = $this->api->allServers();

        $keys = [
            'search',
            'gender-m',
            'gender-f',
            'has_tribe-y',
            'has_tribe-n',
            'order_by',
            'order',
            'only_online',
            'only_donators',
            'search_type',
            'page'
        ];

        if($servers->count()){
            foreach($servers as $server) {
                $keys[] = 'server_' . $server->id;
            }
        }

        $result = $this->api->search(
            $request->only($keys)
        );

        return view('pages.v3.inspector.index', [
            'servers' => $servers,
            'results' => $result
        ]);
    }
}