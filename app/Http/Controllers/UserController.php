<?php namespace App\Http\Controllers;

use Dompdf\Dompdf;
use GameserverApp\Helpers\SiteHelper;
use GuzzleHttp\Exception\ClientException;
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
            return view('pages.v3.user.disabled', [
                'user' => $this->api->user($id)
            ]);
        }

        return redirect(route('user.activity', $id));
    }

    public function activity(Request $request, $id)
    {
        if(!SiteHelper::featureEnabled('user_page')) {
            return view('pages.v3.user.disabled', [
                'user' => $this->api->user($id)
            ]);
        }

        $data = $this->api->userActivity($id);

        $user = $data['user'];
        $activity = $data['activity'];

        return view('pages.v3.user.activity', [
            'user' => $user,
            'activity' => $activity
        ]);
    }

    public function deliveries()
    {
        if(! SiteHelper::featureEnabled('shop')) {
            return view('pages.v3.user.disabled', [
                'user' => auth()->user()
            ]);
        }

        $orders = $this->api->deliveries(route('user.deliveries', auth()->id()));

        return view('pages.v3.user.deliveries', [
            'orders' => $orders,
            'user' => auth()->user()
        ]);
    }

    public function invoices()
    {
        try {
            $invoices = $this->api->invoices(route('user.invoices', auth()->id()));
        } catch (ClientException $e) {
            if($e->getCode() == 401) {
                $invoices = 'DISABLED';
            }
        }

        return view('pages.v3.user.invoices', [
            'invoices' => $invoices,
            'user' => auth()->user()
        ]);
    }

    public function downloadInvoice(Request $request, $uuid, $saleId)
    {
        try {
            $data = $this->api->downloadInvoice($saleId);
        } catch (ClientException $e) {

            if($e->getCode() == 401) {
                return redirectBackWithAlert('Invoices are currently not available. Contact the owner of the community to activate the invoices.', 'danger');
            }

            return Client::exceptionToAlert($e);
        }

        $dompdf = new Dompdf();

        $html = view('pages.v3.user._invoice_pdf', [
            'invoice' => $data->invoice,
            'buyerDetails' => $data->buyerDetails,
            'sellerDetails' => $data->sellerDetails,
            'sellerNote' => $data->sellerNote
        ]);

        $dompdf->loadHtml($html);

        $dompdf->render();

        return $dompdf->stream();
    }

    public function settings(Request $request)
    {
        if($request->has('alert')) {

            app(OAuthApi::class)->clearCache(
                'get',
                'user/me',
                OauthApi::requestOriginInfo(),
                true
            );

            session()->flash('alert', [
                'status'  => $request->get('alert_type', 'success'),
                'message' => $request->get('alert'),
                'stay'    => true
            ]);

            return redirect(route('user.settings', 'me'));
        }

        return view('pages.v3.user.settings', [
            'user' => auth()->user()
        ]);
    }

    public function acceptRules(Request $request, $id)
    {
        try {
            $this->api->acceptRules();
        } catch (ClientException $e) {
            return Client::exceptionToAlert($e);
        }

        app(OAuthApi::class)->clearCache(
            'get',
            'user/me',
            OauthApi::requestOriginInfo(),
            true
        );

        return redirect('/')->with([
            'alert' => [
                'status'  => 'success',
                'message' => 'Thank you for accepting the rules!'
            ]
        ]);
    }

    public function storeSettings(Request $request)
    {
        $this->validate($request, [
            'email' => 'email:rfc,dns|nullable'
        ]);

        try {
            $response = $this->api->updateUser(auth()->id(), $request->only([
                'email',
                'notify_message',
                'notify_webalert',
                'notify_forum',
            ]));
        } catch (ClientException $e) {
            return Client::exceptionToAlert($e);
        }

        app(OAuthApi::class)->clearCache(
            'get',
            'user/me',
            OauthApi::requestOriginInfo(),
            true
        );

        return redirect()->back()->with([
            'alert' => [
                'status'  => 'success',
                'message' => 'Settings saved'
            ]
        ]);
    }

    public function kick(Request $request)
    {
        try {
            $this->api->kickUser();
        } catch (ClientException $e) {
            return Client::exceptionToAlert($e);
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
        try {
            $response = $this->api->resendConfirmEmail($request->get('code'));
        } catch (ClientException $e) {
            return Client::exceptionToAlert($e);
        }

        return redirect(route('user.settings', auth()->user()->id))->with([
            'alert' => [
                'status'  => 'success',
                'message' => 'Confirmation e-mail was send'
            ]
        ]);
    }

    public function confirmEmail(Request $request)
    {
        try {
            $this->api->confirmEmail($request->get('code'));
        } catch (ClientException $e) {
            return Client::exceptionToAlert($e);
        }

        app(OAuthApi::class)->clearCache(
            'get',
            'user/me',
            OauthApi::requestOriginInfo(),
            true
        );

        return redirect(route('user.settings', auth()->user()->id))->with([
            'alert' => [
                'status'  => 'success',
                'message' => 'Thank you! You e-mail address is now confirmed.'
            ]
        ]);
    }
}