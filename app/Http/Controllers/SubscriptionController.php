<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GameserverApp\Api\Client;
use GameserverApp\Helpers\SiteHelper;

class SubscriptionController extends Controller
{
    /**
     * @var Client
     */
    private $client;

    /**
     * TokenController constructor.
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function index(Request $request)
    {
        if(! SiteHelper::featureEnabled('supporter_tiers')) {
            return view('pages.v1.supporter-tier.disabled');
        }

        $subscriptions = $this->client->allUserSubscriptions(route('subscription.index'));

        return view('pages.v1.subscription.index', [
            'subscriptions' => $subscriptions
        ]);
    }

    public function show(Request $request, $id)
    {
        if(! SiteHelper::featureEnabled('supporter_tiers')) {
            return view('pages.v1.supporter-tier.disabled');
        }

        $package = $this->client->supporterTier($id);

        return view('pages.v1.supporter-tier.show', [
            'package' => $package
        ]);
    }
}