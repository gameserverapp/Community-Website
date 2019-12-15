<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GameserverApp\Api\Client;
use GameserverApp\Helpers\SiteHelper;

class TokenController extends Controller
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

    public function index()
    {
        if(! SiteHelper::featureEnabled('tokens')) {
            return view('pages.v1.token.disabled');
        }

        $transactions = $this->client->allUserTransactions(route('token.index'));

        return view('pages.v1.token.index', [
            'transactions' => $transactions
        ]);
    }

    public function buy()
    {
        if(! SiteHelper::featureEnabled('tokens')) {
            return view('pages.v1.token.disabled');
        }

        $packages = $this->client->allTokens(route('token.index'));

        return view('pages.v1.token.buy', [
            'packages' => $packages
        ]);
    }

    public function show(Request $request, $id)
    {
        if(! SiteHelper::featureEnabled('tokens')) {
            return view('pages.v1.token.disabled');
        }

        $package = $this->client->token($id);

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
            }
        }

        return view('pages.v1.token.show', [
            'package' => $package
        ]);
    }
}