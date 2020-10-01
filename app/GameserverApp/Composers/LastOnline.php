<?php
namespace GameserverApp\Composers;

use Illuminate\View\View;
use GameserverApp\Api\Client;
use GameserverApp\Transformers\CharacterTransformer;
use GameserverApp\Transformers\GroupTransformer;

class LastOnline extends AbstractStatsComposer
{

    public function compose(View $view)
    {
        $data = $this->basicStats($view, 'last-online');

        $characters = CharacterTransformer::transformMultiple($data);

        $view->with([
            'characters' => $characters
        ]);
    }
}