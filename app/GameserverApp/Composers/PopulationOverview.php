<?php
namespace GameserverApp\Composers;

use Illuminate\View\View;
use GameserverApp\Api\Client;
use GameserverApp\Api\OAuthApi;

class PopulationOverview
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
        $stats = [];

        $stats[] = [
            'name' => 'Fresh survivors',
            'col' => 6,
            'route' => 'new-characters'
        ];

        $stats[] = [
            'name' => 'Online players',
            'col' => 6,
            'route' => 'online-players'
        ];

        $stats[] = [
            'name' => 'Hours played per day',
            'col' => 12,
            'route' => 'hours-played'
        ];

        $view->with([
            'stats' => $stats
        ]);
    }
}