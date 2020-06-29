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
            return view('pages.v1.supporter-tier.disabled');
        }

        $packages = $this->client->allSupporterTiers(route('supporter-tier.index'));

        if($request->has('status') == 'success') {
            session()->flash('alert', [
                'status'  => 'success',
                'message' => 'Thank you for showing your support!',
                'stay'    => true
            ]);
        }

        return view('pages.v1.supporter-tier.index', [
            'packages' => $packages
        ]);
    }

    public function show(Request $request, $id)
    {
        if(! SiteHelper::featureEnabled('supporter_tiers')) {
            return view('pages.v1.supporter-tier.disabled');
        }

        $package = $this->client->supporterTier($id);

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
                        'message' => 'You need to have a character to order this Supporter Tier.',
                        'stay'    => true
                    ]);
                    break;

                case 'not-available':
                    session()->flash('alert', [
                        'status'  => 'warning',
                        'message' => 'Subscriptions are currently not supported.',
                        'stay'    => true
                    ]);
                    break;
            }
        }

        return view('pages.v1.supporter-tier.show', [
            'package' => $package
        ]);
    }
}