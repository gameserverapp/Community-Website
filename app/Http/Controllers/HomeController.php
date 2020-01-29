<?php namespace App\Http\Controllers;


use App\Http\Controllers\Forum\CategoryController;
use Illuminate\Http\Request;
use GameserverApp\Api\Client;
use GameserverApp\Api\OAuthApi;
use GameserverApp\Helpers\RouteHelper;
use GameserverApp\Models\Character;
use GameserverApp\Models\Server;

class HomeController extends Controller
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
        if ($request->has('autoreload')) {
            return redirect(route('home.index'))->with('alert', [
                'status'  => 'info',
                'message' => 'Automatic-reload feature enabled :)',
                'stay'    => true
            ]);
        }

        if(RouteHelper::home()) {

            switch(RouteHelper::home()) {
                case 'forum':
                    return redirect('/forum');

                default:
                    $pageController = app(PageController::class);
                    return $pageController->show(RouteHelper::home());
            }
        }

        $top = $this->api->characters('top');
        
        $fresh = $this->api->characters('fresh');

        $online = $this->api->characters('online');

        try {
            $servers = $this->api->allServers();
        } catch (\Exception $e) {
            $servers = $this->api->allServers(false);
        }

        $spotlight = $this->api->spotlight('character');

        $articles = $this->api->latestNews();
        $forumPosts = $this->api->latestForumThreads();

        $stats = [];

        if ($newCharacters = $this->api->stats('domain', 'new-characters')) {
            $stats['Fresh survivors'] = (array) $newCharacters;
            $stats['Fresh survivors']['col'] = 6;
        }

        if ($onlinePlayers = $this->api->stats('domain', 'online-players')) {
            $stats['Online players'] = (array) $onlinePlayers;
            $stats['Online players']['col'] = 6;
        }
        if ($hoursPlayed = $this->api->stats('domain', 'hours-played')) {
            $stats['Hours played per day'] = (array) $hoursPlayed;
            $stats['Hours played per day']['col'] = 12;
        }

        return view('pages.v1.home.default.index',[
            'characters' => [
                'top' => $top,
                'fresh' => $fresh,
                'online' => $online
            ],
            'servers' => $servers,
            'spotlight' => $spotlight,
            'lastForumThreads' => $forumPosts,
            'lastNewsPosts' => $articles,
            'stats' => $stats
        ]);
    }

    public function purge()
    {
        $this->api->clearCache('get', 'domain/settings');
    }

    public function verify(Request $request, $code)
    {
        $this->api->verifyDomain($code);

        return response('done');
    }
}