<?php
namespace GameserverApp\Composers;

use App\GameserverApp\Composers\BaseComposer;
use Illuminate\View\View;
use GameserverApp\Api\Client;
use GameserverApp\Api\OAuthApi;

class PanelsLast5FreshSurvivors extends BaseComposer
{
    protected function data()
    {
        return $this->api->characters('fresh');
    }

    protected function defaultData()
    {
        return [
            'characters' => collect([])
        ];
    }

    protected function output($data)
    {
        return [
            'characters' => $data
        ];
    }
}