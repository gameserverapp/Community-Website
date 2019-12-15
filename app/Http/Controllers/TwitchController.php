<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GameserverApp\Api\Client;
use GameserverApp\Api\OAuthApi;
use GameserverApp\Models\Character;

class TwitchController extends Controller
{
    private $api;

    public function __construct()
    {
        $this->api = app(Client::class);
    }

    public function connect()
    {
        if(auth()->user()->twitchOAuthRedirect()) {
            return redirect(auth()->user()->twitchOAuthRedirect());
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
                'message' => 'Your Twitch account is now connected!'
            ]
        ]);
    }

    public function disconnected()
    {
        app(OAuthApi::class)->clearCache('get', 'user/me', [], true);

        return redirect(route('user.settings', auth()->user()->id))->with([
            'alert' => [
                'status'  => 'success',
                'message' => 'Your Twitch account was removed from your account!'
            ]
        ]);
    }

    public function failed(Request $request)
    {

        switch($request->get('reason', false)) {
            case 'duplicate':
                $msg = 'Your Twitch account is already connected to an account. Please disconnect the other account or contact your admin.';
                break;

            default:
                $msg = 'Twitch connection failed. Please try again or contact your admin.';
                break;
        }

        return redirect(route('user.settings', auth()->user()->id))->with([
            'alert' => [
                'status'  => 'danger',
                'message' => $msg
            ]
        ]);
    }

    public function sync()
    {
        $this->api->twitchSync();

        return redirect()->back()->with([
            'alert' => [
                'status'  => 'success',
                'message' => 'Your Twitch account will be synced shortly!'
            ]
        ]);
    }

    public function disconnect()
    {
        $this->api->twitchDisconnect();

        app(OAuthApi::class)->clearCache('get', 'user/me', [], true);

        return redirect()->back()->with([
            'alert' => [
                'status'  => 'success',
                'message' => 'Your Twitch account is disconnected!'
            ]
        ]);
    }
}