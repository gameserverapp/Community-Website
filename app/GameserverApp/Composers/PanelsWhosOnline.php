<?php
namespace GameserverApp\Composers;

use App\GameserverApp\Composers\BaseComposer;
use Illuminate\View\View;

class PanelsWhosOnline extends BaseComposer
{

    protected function data()
    {
        return $this->api->characters('online');
    }

    protected function defaultData()
    {
        return [
            'characters' => collect([]),
            'totalOnline' => 0
        ];
    }

    protected function output($data)
    {
        return [
            'characters' => $data->characters,
            'totalOnline' => $data->totalOnline
        ];
    }
}