<?php namespace App\Http\Controllers;

use GameserverApp\Helpers\SiteHelper;
use Illuminate\Http\Request;
use GameserverApp\Api\Client;
use GameserverApp\Api\OAuthApi;
use GameserverApp\Models\Character;
use Illuminate\Support\Facades\Cookie;

class UserController extends Controller
{
    private $api;
    
    public function __construct()
    {
        $this->api = app(Client::class);
    }

    public function switchTheme(Request $request)
    {
        $this->validate($request, [
            'theme' => 'required'
        ]);

        Cookie::queue('override_theme', $request->input('theme'));

        return redirect()->back();
    }

    public function show(Request $request, $id)
    {
        if(!SiteHelper::featureEnabled('user_page')) {
            return view('pages.v3.user.disabled');
        }

        return redirect(route('user.activity', $id));
    }

    public function activity(Request $request, $id)
    {
        if(!SiteHelper::featureEnabled('user_page')) {
            return view('pages.v3.user.disabled');
        }

        $data = $this->api->userActivity($id);

        $user = $data['user'];
        $activity = $data['activity'];

        return view('pages.v3.user.activity', [
            'user' => $user,
            'activity' => $activity
        ]);
    }

//    public function about(Request $request, $id)
//    {
//        $user = $this->api->user($id);
//
//        return view('pages.v3.user.about', [
//            'user' => $user
//        ]);
//    }

    public function orderHistory()
    {
        if(! SiteHelper::featureEnabled('shop')) {
            return view('pages.v3.user.disabled');
        }

        $orders = $this->api->shopOrders(route('shop.orders', auth()->id()));

        return view('pages.v3.user.history', [
            'orders' => $orders,
            'user' => auth()->user()
        ]);
    }

    public function settings(Request $request)
    {
        return view('pages.v3.user.settings', [
            'user' => auth()->user()
        ]);
    }

    public function acceptRules(Request $request, $id)
    {
        $this->api->acceptRules();

        app(OAuthApi::class)->clearCache('get', 'user/me', [], true);

        return redirect('/')->with([
            'alert' => [
                'status'  => 'success',
                'message' => 'Thank you for accepting the rules!'
            ]
        ]);
    }

    public function storeSettings(Request $request)
    {
        $response = $this->api->updateUser(auth()->id(), $request->only([
            'email',
            'notify_message',
            'notify_webalert',
            'notify_forum',
            'twitch_username'
        ]));

        if($response instanceof \Exception) {

            if($response->getCode() == 422) {
                $message = json_decode($response->getResponse()->getBody());
                return redirect()->back()->withErrors($message);
            }

            $message = json_decode($response->getResponse()->getBody())->message;

            session()->flash('alert', [
                'status'  => 'danger',
                'message' => $message,
                'stay'    => true
            ]);

            return redirect()->back();
        }

        app(OAuthApi::class)->clearCache('get', 'user/me', [], true);

        if(isset( $response->errors )) {
            return redirect()->back()->withErrors($response->errors);
        }

        return redirect()->back()->with([
            'alert' => [
                'status'  => 'success',
                'message' => 'Settings saved'
            ]
        ]);
    }

    public function kick(Request $request)
    {
        $response = $this->api->kickUser();

        if(isset( $response->errors )) {
            return redirect()->back()->withErrors($response->errors);
        }

        return redirect()->back()->with([
            'alert' => [
                'status'  => 'success',
                'message' => 'Kick requested'
            ]
        ]);
    }

    public function resendConfirmEmail(Request $request)
    {
        $response = $this->api->resendConfirmEmail($request->get('code'));

        $route = route('user.settings', auth()->user()->id);

        if($response instanceof \Exception) {
            $message = json_decode($response->getResponse()->getBody())->message;

            session()->flash('alert', [
                'status'  => 'danger',
                'message' => $message,
                'stay'    => true
            ]);

            return redirect($route);
        }

        return redirect($route)->with([
            'alert' => [
                'status'  => 'success',
                'message' => 'Confirmation e-mail was send'
            ]
        ]);
    }

    public function confirmEmail(Request $request)
    {
        $response = $this->api->confirmEmail($request->get('code'));

        $route = '/';

        if(auth()->check()) {
            $route = route('user.settings', auth()->user()->id);
        }

        if($response instanceof \Exception) {
            $message = json_decode($response->getResponse()->getBody())->message;

            session()->flash('alert', [
                'status'  => 'danger',
                'message' => $message,
                'stay'    => true
            ]);

            return redirect($route);
        }

        app(OAuthApi::class)->clearCache('get', 'user/me', [], true);

        return redirect('/')->with([
            'alert' => [
                'status'  => 'success',
                'message' => 'Thank you! You e-mail address is now confirmed.'
            ]
        ]);
    }
}