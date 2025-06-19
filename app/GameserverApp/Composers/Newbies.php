<?php
namespace GameserverApp\Composers;

use Illuminate\View\View;
use GameserverApp\Api\Client;
use GameserverApp\Transformers\CharacterTransformer;
use GameserverApp\Transformers\GroupTransformer;

class Newbies extends AbstractStatsComposer
{
    public function compose(View $view)
    {
        try {
            $data = $this->basicStats($view, 'newbies');
            $characters = CharacterTransformer::transformMultiple($data);
        } catch (\Exception $e) {
            $characters = collect([]);
        }

        $view->with([
            'characters' => $characters
        ]);
    }
}