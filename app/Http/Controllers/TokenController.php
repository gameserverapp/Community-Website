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

    public function send(Request $request, $uuid)
    {
        if(! auth()->user()->canSendTokens()) {
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

        $response = $this->client->sendTokens(
            $uuid,
            $request->input('amount'),
            $request->input('message')
        );

        if(
            $response instanceof \Exception or
            is_null($response)
        ) {
            $error = json_decode($response->getResponse()->getBody());

            if(isset($error->errors)) {
                return redirect()->back()->withErrors($error->errors)->withInput();
            }

            if(isset($error->message)) {
                return redirect()->back()->withErrors($error)->withInput();
            }

            return redirectBackWithAlert('Something went wrong. Please try again.', 'danger');
        }

        return redirectBackWithAlert('Tokens were sent!');
    }
}