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
            return view('pages.v3.user.disabled');
        }

        $transactions = $this->client->allUserTransactions(route('token.index', auth()->id()));

        return view('pages.v3.user.transactions.index', [
            'transactions' => $transactions,
            'user' => auth()->user()
        ]);
    }
}