<?php
namespace GameserverApp\Composers;

use Illuminate\View\View;
use GameserverApp\Api\Client;
use GameserverApp\Transformers\CharacterTransformer;
use GameserverApp\Transformers\GroupTransformer;

class TopPlayers extends AbstractStatsComposer
{

    public function compose(View $view)
    {
        try {
            $data = $this->basicStats($view, 'top-players');
            $characters = CharacterTransformer::transformMultiple($data);
        } catch (\Exception $e) {
            $characters = collect([]);
        }

        $view->with([
            'characters' => $characters
        ]);
    }
}