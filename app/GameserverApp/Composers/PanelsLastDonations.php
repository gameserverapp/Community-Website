<?php
namespace GameserverApp\Composers;

use Illuminate\View\View;
use GameserverApp\Api\Client;
use GameserverApp\Api\OAuthApi;

class PanelsLastDonations
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
            'sales' => $this->api->saleStats('last-5')
        ]);
    }
}