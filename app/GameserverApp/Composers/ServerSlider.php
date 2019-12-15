<?php
namespace GameserverApp\Composers;

use Illuminate\View\View;
use GameserverApp\Api\Client;
use GameserverApp\Api\OAuthApi;

class ServerSlider
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
            $servers = $this->api->allServers();
        } catch (\Exception $e) {
            try {
                $servers = $this->api->allServers(false);
            } catch (\Exception $e) {
                $servers = collect();
            }
        }

        $view->with([
            'servers' => $servers
        ]);
    }
}