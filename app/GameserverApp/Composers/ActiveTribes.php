<?php
namespace GameserverApp\Composers;

use Illuminate\View\View;
use GameserverApp\Transformers\TribeTransformer;

class ActiveTribes extends AbstractStatsComposer
{

    public function compose(View $view)
    {
        $data = $this->basicStats($view, 'active-tribes');

        $tribes = TribeTransformer::transformMultiple($data);

        $view->with([
            'tribes' => $tribes
        ]);
    }
}