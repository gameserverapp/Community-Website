<?php

namespace App\GameserverApp\Composers;

use App\Exceptions\DomainNotFoundException;
use GameserverApp\Api\Client;
use Illuminate\View\View;

class BaseComposer
{

    /**
     * @var Client
     */
    protected $api;

    public function __construct()
    {
        $this->api = app(Client::class);
    }

    protected function defaultData()
    {
        return [];
    }

    public function compose(View $view)
    {
        try {
            $data = $this->data();
        } catch( DomainNotFoundException $e) {
            $data = $this->defaultData();
        }

        $data = (object) $data;

        $view->with($this->output($data));
    }
}