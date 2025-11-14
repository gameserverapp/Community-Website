<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GameserverApp\Api\Client;
use GameserverApp\Helpers\SiteHelper;

class SupporterTierController extends Controller
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
            return view('pages.v3.supporter-tier.disabled');
        }

        $packages = $this->client->allSupporterTiers(route('supporter-tier.index'), request()->get('page', 1));
        
        $this->flashResponse($request);

        return view('pages.v3.supporter-tier.index', [
            'packages' => $packages
        ]);
    }

    public function show(Request $request, $id)
    {
        if(! SiteHelper::featureEnabled('supporter_tiers')) {
            return view('pages.v3.supporter-tier.disabled');
        }

        $package = $this->client->supporterTier($id);

        $this->flashResponse($request);

        return view('pages.v3.supporter-tier.show', [
            'package' => $package
        ]);
    }

    public function purge($id)
    {
        $this->client->clearCache('get', 'supporter-tier');
        $this->client->clearCache('get', 'supporter-tier/show/' . $id);
    }

    private function flashResponse(Request $request)
    {
        if ($request->has('status')) {
            switch ($request->get('status')) {
                case 'cancel':
                    session()->flash('alert', [
                        'status'  => 'warning',
                        'message' => 'Your order was cancelled',
                        'stay'    => true
                    ]);
                    break;

                case 'error':
                    session()->flash('alert', [
                        'status'  => 'warning',
                        'message' => 'There was an error during the process. Please try again or contact the admin.',
                        'stay'    => true
                    ]);
                    break;

                case 'discord-error':
                    session()->flash('alert', [
                        'status'  => 'warning',
                        'message' => 'Please make sure to connect your Discord account before purchasing this Supporter Tier.',
                        'stay'    => true
                    ]);
                    break;

                case 'no-char-error':
                    session()->flash('alert', [
                        'status'  => 'warning',
                        'message' => 'You need to select a character to order this Supporter Tier.',
                        'stay'    => true
                    ]);
                    break;

                case 'no-gameserver-error':
                    session()->flash('alert', [
                        'status'  => 'warning',
                        'message' => 'You need to select a game server to order this Supporter Tier.',
                        'stay'    => true
                    ]);
                    break;

                case 'missing-service-user-error':
                    session()->flash('alert', [
                        'status'  => 'warning',
                        'message' => 'You need to connect your in-game account to your profile to order this package.',
                        'stay'    => true
                    ]);
                    break;

                case 'paypal-missing-product-id':
                    session()->flash('alert', [
                        'status'  => 'warning',
                        'message' => 'The PayPal product ID was not properly set. Ask the admin to update the Supporter Tier.',
                        'stay'    => true
                    ]);
                    break;

                case 'invalid-psp':
                    session()->flash('alert', [
                        'status'  => 'warning',
                        'message' => 'The selected payment provider is not available or invalid.',
                        'stay'    => true
                    ]);
                    break;

                case 'not-available':
                    session()->flash('alert', [
                        'status'  => 'warning',
                        'message' => 'This feature is currently not supported.',
                        'stay'    => true
                    ]);
                    break;

                case 'success':
                    session()->flash('alert', [
                        'status'  => 'success',
                        'message' => 'Thank you for your support!',
                        'stay'    => true
                    ]);
                    break;
            }
        }
    }
}