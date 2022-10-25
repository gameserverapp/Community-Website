<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GameserverApp\Api\Client;
use GameserverApp\Api\OAuthApi;
use GameserverApp\Models\Character;

class PatreonController extends Controller
{
    private $api;

    public function __construct()
    {
        $this->api = app(Client::class);
    }

    public function connect()
    {
        if(auth()->user()->patreonOAuthRedirect()) {
            return redirect(auth()->user()->patreonOAuthRedirect());
        }

        return redirect()->back()->with([
            'alert' => [
                'status'  => 'warning',
                'message' => 'Something went wrong. Please try again or contact your admin.'
            ]
        ]);
    }

    public function success()
    {
        app(OAuthApi::class)->clearCache('get', 'user/me', [], true);

        return redirect(route('user.settings', auth()->user()->id))->with([
            'alert' => [
                'status'  => 'success',
                'message' => 'Your Patreon account is now connected!'
            ]
        ]);
    }

    public function failed(Request $request)
    {

        switch($request->get('reason', false)) {
            case 'duplicate':
                $msg = 'Your Patreon account is already connected to an account. Please disconnect the other account or contact your admin.';
                break;

            default:
                $msg = 'Patreon connection failed. Please try again or contact the admin.';
                break;
        }

        return redirect(route('user.settings', auth()->user()->id))->with([
            'alert' => [
                'status'  => 'danger',
                'message' => $msg
            ]
        ]);
    }

    public function disconnected()
    {
        app(OAuthApi::class)->clearCache('get', 'user/me', [], true);

        return redirect(route('user.settings', auth()->user()->id))->with([
            'alert' => [
                'status'  => 'success',
                'message' => 'Your Patreon account was removed from your account!'
            ]
        ]);
    }

    public function disconnect()
    {
        $this->api->patreonDisconnect();

        app(OAuthApi::class)->clearCache('get', 'user/me', [], true);

        return redirect()->back()->with([
            'alert' => [
                'status'  => 'success',
                'message' => 'Your Patreon account is disconnected!'
            ]
        ]);
    }
}