<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GameserverApp\Api\Client;
use GameserverApp\Api\OAuthApi;
use GameserverApp\Models\Character;

class DiscordController extends Controller
{
    private $api;

    public function __construct()
    {
        $this->api = app(Client::class);
    }

    public function connect()
    {
        if(auth()->user()->discordOAuthRedirect()) {
            return redirect(auth()->user()->discordOAuthRedirect());
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
        if(!auth()->check()) {
            if(!auth()->check()) {
                session()->flash('alert', [
                    'status'  => 'success',
                    'message' => 'Your Discord account is now connected!'
                ]);
                return view('pages.v1.discord.success');
            }
        }

        app(OAuthApi::class)->clearCache('get', 'user/me', [], true);

        return redirect(route('user.settings', auth()->user()->id))->with([
            'alert' => [
                'status'  => 'success',
                'message' => 'Your Discord account is now connected!'
            ]
        ]);
    }

    public function failed(Request $request)
    {

        switch($request->get('reason', false)) {
            case 'duplicate':
                $msg = 'Your Discord account is already connected to an account. Please disconnect the other account or contact your admin.';
                break;

            default:
                $msg = 'Discord connection failed. Please try again or contact the admin.';
                break;
        }

        if(!auth()->check()) {
            if(!auth()->check()) {

                session()->flash('alert', [
                    'status'  => 'danger',
                    'message' => $msg
                ]);

                return view('pages.v1.discord.failed', [
                    'reason' => $request->get('reason', false)
                ]);
            }
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
                'message' => 'Your Discord account was removed from your account!'
            ]
        ]);
    }

    public function disconnect()
    {
        $this->api->discordDisconnect();

        app(OAuthApi::class)->clearCache('get', 'user/me', [], true);

        return redirect()->back()->with([
            'alert' => [
                'status'  => 'success',
                'message' => 'Your Discord account is disconnected!'
            ]
        ]);
    }
}