<?php
namespace GameserverApp\Composers;

use App\GameserverApp\Composers\BaseComposer;

class PanelsTop5Characters extends BaseComposer
{
    protected function data()
    {
        return $this->api->characters('top');
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