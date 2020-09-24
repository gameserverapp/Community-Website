<?php
namespace GameserverApp\Composers;

use Illuminate\View\View;
use GameserverApp\Api\Client;
use GameserverApp\Transformers\CharacterTransformer;
use GameserverApp\Transformers\GroupTransformer;

class OnlineCountLast7Days extends AbstractStatsComposer
{
    public function compose(View $view)
    {
        $data = $this->basicStats($view, 'online-count-last-7-days');

        $view->with([
            'stat' => (array) $data
        ]);
    }
}