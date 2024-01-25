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
        return redirect(route('message.inbox', auth()->id()));
    }

    public function inbox()
    {
        if(! SiteHelper::featureEnabled('messages')) {
            return view('pages.v3.user.disabled');
        }

        $messages = $this->api->messages('inbox', route('message.inbox', auth()->id()));

        return view('pages.v3.user.message.mailbox', [
            'title' => 'Inbox',
            'contacts' => $this->myContacts(),
            'messages' => $messages
        ]);
    }

    public function outbox()
    {
        if(! SiteHelper::featureEnabled('messages')) {
            return view('pages.v3.user.disabled');
        }

        $messages = $this->api->messages('outbox', route('message.outbox', auth()->id()));

        return view('pages.v3.user.message.mailbox',[
            'title' => 'Outbox',
            'contacts' => $this->myContacts(),
            'messages' => $messages
        ]);
    }

    public function show(Request $request, $uuid, $id)
    {
        if(! SiteHelper::featureEnabled('messages')) {
            return view('pages.v3.user.disabled');
        }

        $message = $this->api->message($id);

        if(!$message->read()) {
            $this->api->clearCache('get', 'user/' . auth()->user()->id);
            $this->api->clearCache('get', 'message/' . $id);
        }

        return view('pages.v3.user.message.read', [
            'message' => $message
        ]);
    }

    public function create(Request $request, $id)
    {
        if(! SiteHelper::featureEnabled('messages')) {
            return view('pages.v3.user.disabled');
        }

        if(!auth()->user()->canSendMessage()) {
            return redirectBackWithAlert('You can not do this', 'danger');
        }

        $user = $this->api->user($id);

        return view('pages.v3.user.message.create', [
            'receiver' => $user
        ]);
    }

    public function send(Request $request, $id)
    {
        if(! SiteHelper::featureEnabled('messages')) {
            return view('pages.v3.user.disabled');
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
                return redirect()->back()->withErrors($error->errors)->withInput();
            }

            return redirectBackWithAlert('Something went wrong. Please try again.', 'danger');
        }

        return redirect(route('message.outbox', auth()->id()))->with([
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