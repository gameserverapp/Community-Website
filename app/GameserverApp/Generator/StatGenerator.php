<?php

namespace GameserverApp\Generator;

use GameserverApp\Api\Client;
use Illuminate\View\View;

class StatGenerator
{
    /**
     * @var Client
     */
    private $api;

    /**
     * HomeController constructor.
     *
     * @param Client $api
     */
    public function __construct()
    {
        $this->api = app(Client::class);
    }

    public function basicStats($value, $type)
    {
        try {
            if(is_null($value)) {
                $data = $this->api->stats(
                    'domain',
                    $type
                );
            } elseif(strpos($value, 'cluster-') !== false) {
                $value = str_replace('cluster-', '', $value);

                $data = $this->api->stats(
                    'cluster',
                    $type,
                    $value
                );
            } else {

                $value = str_replace('server-', '', $value);
                $data = $this->api->stats(
                    'server',
                    $type,
                    $value
                );
            }
        } catch (\Exception $e) {
            $data = [
                'data' => '',
                'options' => ''
            ];
        }

        return (array) $data;
    }
}