<?php namespace App\Http\Controllers;


use GameserverApp\Helpers\SiteHelper;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use Illuminate\Http\Request;
use GameserverApp\Api\Client;

class ShopController extends Controller
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

    public function index(Request $request)
    {
        if(! SiteHelper::featureEnabled('shop')) {
            return view('pages.v1.shop.disabled');
        }

        $packs = $this->client->shopItems(route('shop.index'));

        if($request->has('status') == 'success') {
            session()->flash('alert', [
                'status'  => 'success',
                'message' => 'Thank you for your order! Your tokens are being processed.',
                'stay'    => true
            ]);
        }

        return view('pages.v1.shop.index', [
            'packs' => $packs,
        ]);
    }

    public function show(Request $request, $id)
    {
        if(! SiteHelper::featureEnabled('shop')) {
            return view('pages.v1.shop.disabled');
        }

        $pack = $this->client->shopItem($id);

        return view('pages.v1.shop.show', [
            'pack' => $pack
        ]);
    }

    public function orders()
    {
        if(! SiteHelper::featureEnabled('shop')) {
            return view('pages.v1.shop.disabled');
        }

        $orders = $this->client->shopOrders(route('shop.index'));

        return view('pages.v1.shop.history', [
            'orders' => $orders
        ]);
    }

    public function purchase(Request $request, $id)
    {
        $response = $this->client->purchaseShopItem($id);

        if(
            $response instanceof ClientException or
            $response instanceof ServerException
        ) {

            $message = json_decode($response->getResponse()->getBody())->message;

            session()->flash('alert', [
                'status'  => 'danger',
                'message' => $message,
                'stay'    => true
            ]);

            return redirect()->back();
        }

        session()->flash('alert', [
            'status'  => 'success',
            'message' => $response->data,
            'stay'    => true
        ]);

        return redirect(route('shop.index'));
    }
}