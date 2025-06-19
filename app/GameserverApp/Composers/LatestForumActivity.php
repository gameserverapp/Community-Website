<?php
namespace GameserverApp\Composers;

use Illuminate\View\View;
use GameserverApp\Api\Client;
use GameserverApp\Api\OAuthApi;

class LatestForumActivity
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
            $data = $this->api->latestForumThreads();
        } catch (\Exception $e) {
            $data = collect([]);
        }

        $view->with([
            'lastForumThreads' => $data
        ]);
    }
}