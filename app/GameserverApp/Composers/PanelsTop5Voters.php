<?php
namespace GameserverApp\Composers;

use Illuminate\View\View;
use GameserverApp\Api\Client;
use GameserverApp\Api\OAuthApi;

class PanelsTop5Voters
{
    /**
     * @var Client
     */
    private $api;

    public function __construct()
    {
        $this->api = app(Client::class);
    }

    public function compose(View $view)
    {
        $view->with([
            'users' => $this->api->userStats('top-voters')
        ]);
    }
}