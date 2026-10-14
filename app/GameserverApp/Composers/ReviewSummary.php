<?php
namespace GameserverApp\Composers;

use Illuminate\View\View;
use GameserverApp\Api\Client;
use GameserverApp\Api\OAuthApi;

class ReviewSummary
{
    /**
     * @var Client
     */
    private $api;

    public function __construct()
    {
        $this->api = app(Client::class);
    }

    public function compose(View $view)
    {
        try {
            $summary = $this->api->reviewSummary();
        } catch (\Exception $e) {
            $summary = null;
        }

        if(isset($summary->data)) {
            $summary = $summary->data;
        }

        if(is_null($summary)) {
            $summary = 'No review summary available at the moment.';
        }

        $view->with([
            'summary' => $summary
        ]);
    }
}