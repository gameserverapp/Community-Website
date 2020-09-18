<?php namespace App\Http\Controllers;


use Illuminate\Http\Request;
use GameserverApp\Api\Client;
use GameserverApp\Helpers\SiteHelper;

class MessageController extends Controller
{

    private $api;

    public function __construct()
    {
        $this->api = app(Client::class);
    }

    public function index()
    {
        return redirect(route('message.inbox'));
    }

    public function inbox()
    {
        if(! SiteHelper::featureEnabled('messages')) {
            return view('pages.v3.message.disabled');
        }

        $messages = $this->api->messages('inbox', route('message.inbox'));

        return view('pages.v3.message.mailbox', [
            'title' => 'Inbox',
            'contacts' => $this->myContacts(),
            'messages' => $messages
        ]);
    }

    public function outbox()
    {
        if(! SiteHelper::featureEnabled('messages')) {
            return view('pages.v3.message.disabled');
        }

        $messages = $this->api->messages('outbox', route('message.outbox'));

        return view('pages.v3.message.mailbox',[
            'title' => 'Outbox',
            'contacts' => $this->myContacts(),
            'messages' => $messages
        ]);
    }

    public function show(Request $request, $id)
    {
        if(! SiteHelper::featureEnabled('messages')) {
            return view('pages.v3.message.disabled');
        }

        return view('pages.v3.message.read', [
            'message' => $this->api->message($id)
        ]);
    }

    public function create(Request $request, $id)
    {
        if(! SiteHelper::featureEnabled('messages')) {
            return view('pages.v3.message.disabled');
        }

        if(!auth()->user()->canSendMessage()) {
            return redirectBackWithAlert('You can not do this', 'danger');
        }

        return view('pages.v3.message.create', [
            'receiver' => $this->api->user($id)
        ]);
    }

    public function send(Request $request, $id)
    {
        if(! SiteHelper::featureEnabled('messages')) {
            return view('pages.v3.message.disabled');
        }

        if(!auth()->user()->canSendMessage()) {
            return redirectBackWithAlert('You can not do this', 'danger');
        }

        $this->validate($request, [
            'subject' => 'required|string',
            'content' => 'required|string'
        ]);

        $response = $this->api->sendMessage(
            $id,
            $request->input('subject'),
            $request->input('content')
        );

        if(
            $response instanceof \Exception or
            is_null($response)
        ) {
            $error = json_decode($response->getResponse()->getBody());

            if(isset($error->errors)) {
                return redirect()->back()->withErrors($error->errors);
            }

            return redirectBackWithAlert('Something went wrong. Please try again.', 'danger');
        }

        return redirect(route('message.outbox'))->with([
            'alert' => [
                'status' => 'success',
                'message' => 'Message was sent'
            ]
        ]);
    }

    private function myContacts()
    {
        return $this->api->myContacts();
    }
}