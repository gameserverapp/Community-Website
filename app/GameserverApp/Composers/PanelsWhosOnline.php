<?php
namespace GameserverApp\Composers;

use Illuminate\View\View;
use GameserverApp\Api\Client;
use GameserverApp\Api\OAuthApi;

class PanelsWhosOnline
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
        $data = $this->api->characters('online');

        $view->with([
            'characters' => $data->characters,
            'totalOnline' => $data->total_online
        ]);
    }
}