<?php
namespace GameserverApp\Composers;

use Illuminate\View\View;
use GameserverApp\Api\Client;
use GameserverApp\Api\OAuthApi;

class LatestNewsUpdates
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
        try {
            $data = $this->api->latestNews();
        } catch (\Exception $e) {
            $data = collect([]);
        }

        $view->with([
            'lastNewsPosts' => $data
        ]);
    }
}