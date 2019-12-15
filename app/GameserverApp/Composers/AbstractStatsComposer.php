<?php

namespace GameserverApp\Composers;

use GameserverApp\Api\Client;
use Illuminate\View\View;

class AbstractStatsComposer
{
    /**
     * @var Client
     */
    private $api;

    public function __construct()
    {
        $this->api = app(Client::class);
    }

    public function basicStats(View $view, $type)
    {
        if(!isset($view->getData()['value']) or empty($view->getData()['value'])) {
            $data = $this->api->stats(
                'domain',
                $type
            );
        } elseif(strpos($view->getData()['value'], 'cluster-') !== false) {
            $value = str_replace('cluster-', '', $view->getData()['value']);

            $data = $this->api->stats(
                'cluster',
                $type,
                $value
            );
        } else {

            $value = str_replace('server-', '', $view->getData()['value']);
            $data = $this->api->stats(
                'server',
                $type,
                $value
            );
        }

        return $data;
    }
}