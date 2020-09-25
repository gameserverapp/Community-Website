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
        if(RouteHelper::home()) {

            switch(RouteHelper::home()) {
                case 'forum':
                    return redirect('/forum');

                case 'news':
                    return redirect('/news');

                case 'calendar':
                    return redirect('/calendar');

                case 'inspector':
                    return redirect('/inspector');

                case 'shop':
                    return redirect('/shop');

                case 'supporter-tier':
                    return redirect('/supporter-tier');

                default:
                    $pageController = app(PageController::class);
                    return $pageController->show(RouteHelper::home());
            }
        }

        return view('pages.v3.default-template.home');
    }

    public function purge()
    {
        $this->api->clearAllCacheForSite();
    }

    public function verify(Request $request, $code)
    {
        $this->api->verifyDomain($code);

        return response('done');
    }
}