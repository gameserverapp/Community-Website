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

        $view->with([
            'stats' => $stats
        ]);
    }
}