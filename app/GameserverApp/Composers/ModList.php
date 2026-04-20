<?php
namespace GameserverApp\Composers;

use Illuminate\View\View;
use GameserverApp\Api\Client;
use GameserverApp\Api\OAuthApi;

class ModList
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
            $data = $this->api->modList($view->getData()['value']);
        } catch(\Throwable $e) {
            $data = false;
        }

        $view->with([
            'mods' => $data
        ]);
    }
}