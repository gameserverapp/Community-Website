<?php
namespace GameserverApp\Composers;

use Illuminate\View\View;
use GameserverApp\Transformers\GroupTransformer;

class ActiveTribes extends AbstractStatsComposer
{

    public function compose(View $view)
    {
        $data = $this->basicStats($view, 'active-tribes');

        $tribes = GroupTransformer::transformMultiple($data);

        $view->with([
            'tribes' => $tribes
        ]);
    }
}