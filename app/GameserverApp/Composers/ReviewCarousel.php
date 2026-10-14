<?php
namespace GameserverApp\Composers;

use Illuminate\View\View;
use GameserverApp\Api\Client;
use GameserverApp\Api\OAuthApi;

class ReviewCarousel
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
            $reviews = $this->api->recentReviews();
        } catch (\Exception $e) {
            $reviews = collect();
        }

        $view->with([
            'reviews' => $reviews
        ]);
    }
}