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
        $subscriptions = $this->client->allUserSubscriptions(route('subscription.index'));

        if($request->has('status') == 'success') {
            session()->flash('alert', [
                'status'  => 'success',
                'message' => 'Thank you for your support!',
                'stay'    => true
            ]);
        }

        return view('pages.v3.user.subscription.index', [
            'subscriptions' => $subscriptions,
            'user' => auth()->user()
        ]);
    }

    public function changeCharacter(Request $request, $uuid,  $id)
    {
        if(! SiteHelper::featureEnabled('supporter_tiers')) {
            return view('pages.v3.supporter-tier.disabled');
        }

        $this->validate($request, [
            'character_id' => 'required'
        ]);

        $charId = $request->input('character_id');

        try {
            $response = $this->client->changeSubscriptionCharacter($id, $charId);
        } catch (\Exception $e) {
            return Client::exceptionToAlert($e);
        }

        if(isset($response->data)) {
            return redirectBackWithAlert($response->data);
        }

        return redirectBackWithAlert('Something went wrong. Please refresh the page and try again.', 'danger');
    }

    public function cancel(Request $request, $uuid,  $id)
    {
        if(! SiteHelper::featureEnabled('supporter_tiers')) {
            return view('pages.v3.supporter-tier.disabled');
        }

        try {
            $response = $this->client->cancelSubscription($id);
        } catch (\Exception $e) {
            return Client::exceptionToAlert($e);
        }

        if(isset($response->data)) {
            return redirectBackWithAlert($response->data);
        }

        return redirectBackWithAlert('Something went wrong. Please refresh the page and try again.', 'danger');
    }
}