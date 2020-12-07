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

        $characters = collect([]);
        $totalOnline = 0;

        if(isset($data->characters)) {
            $characters = $data->characters;
        }

        if(isset($data->total_online)) {
            $totalOnline = $data->total_online;
        }

        $view->with([
            'characters' => $characters,
            'totalOnline' => $totalOnline
        ]);
    }
}