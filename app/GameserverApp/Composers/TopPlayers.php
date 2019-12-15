<?php
namespace GameserverApp\Composers;

use Illuminate\View\View;
use GameserverApp\Api\Client;
use GameserverApp\Transformers\CharacterTransformer;
use GameserverApp\Transformers\TribeTransformer;

class TopPlayers extends AbstractStatsComposer
{

    public function compose(View $view)
    {
        $data = $this->basicStats($view, 'top-players');

        $characters = CharacterTransformer::transformMultiple($data);

        $view->with([
            'characters' => $characters
        ]);
    }
}