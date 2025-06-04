<?php
namespace GameserverApp\Composers;

use Illuminate\View\View;
use GameserverApp\Api\Client;
use GameserverApp\Api\OAuthApi;

class PanelsDonationTarget
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
            $data = $this->api->monthlyTarget();
        } catch (\Exception $e) {
            $data = (object) [
                'total_income' => 0,
                'target' => 0,
                'percentage' => 0
            ];
        }

        $view->with([
            'target' => $data
        ]);
    }
}