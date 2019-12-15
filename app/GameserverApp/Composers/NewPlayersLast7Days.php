<?php
namespace GameserverApp\Composers;

use Illuminate\View\View;
use GameserverApp\Api\Client;
use GameserverApp\Transformers\CharacterTransformer;
use GameserverApp\Transformers\TribeTransformer;

class NewPlayersLast7Days extends AbstractStatsComposer
{
    public function compose(View $view)
    {
        $data = $this->basicStats($view, 'new-players-last-7-days');

        $view->with([
            'stat' => (array) $data
        ]);
    }
}