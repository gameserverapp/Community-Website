<?php
namespace App\Http\Controllers;

use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use GameserverApp\Api\Client;
use GameserverApp\Helpers\SiteHelper;
use Throwable;

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

        $transactions = $this->client->allUserTransactions(route('token.index'));

        return view('pages.v3.user.transactions.index', [
            'transactions' => $transactions,
            'user' => auth()->user()
        ]);
    }

    public function send(Request $request, $uuid)
    {
        if(
            is_bool(auth()->user()) or
            ! auth()->user()->canSendTokens()
        ) {
            return view('pages.v3.user.disabled');
        }

        $user = $this->client->user($uuid);

        return view('pages.v3.user.send-tokens', [
            'user' => $user,
            'title' => 'Send tokens to ' . $user->name
        ]);
    }

    public function sendSubmit(Request $request, $uuid)
    {
        $this->validate($request, [
            'amount' => 'required|integer|min:1',
            'message' => 'required|max:120'
        ]);

        if(!auth()->user()->canSendTokens()) {
            return redirectBackWithAlert('You can not do this', 'danger');
        }

        try {
            $this->client->sendTokens(
                $uuid,
                $request->input('amount'),
                $request->input('message')
            );
        } catch (ClientException $e) {
            return Client::exceptionToAlert($e);
        }

        return redirectBackWithAlert('Tokens were sent!');
    }
}