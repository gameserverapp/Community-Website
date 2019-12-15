<?php
namespace GameserverApp\Composers;

use Illuminate\View\View;
use GameserverApp\Api\Client;
use GameserverApp\Transformers\CharacterTransformer;
use GameserverApp\Transformers\TribeTransformer;

class Newbies extends AbstractStatsComposer
{
    public function compose(View $view)
    {
        $data = $this->basicStats($view, 'newbies');
        
        $characters = CharacterTransformer::transformMultiple($data);

        $view->with([
            'characters' => $characters
        ]);
    }
}