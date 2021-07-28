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
            return view('pages.v3.shop.disabled');
        }

        $packs = $this->client->shopItems(route('shop.index'), $request->get('category', ''));

        $categories = false;

        if(isset($packs->categories)) {
            $categories = $packs->categories;
        }

        if($request->has('status') == 'success') {
            session()->flash('alert', [
                'status'  => 'success',
                'message' => 'Thank you for your order! Your tokens are being processed.',
                'stay'    => true
            ]);
        }

        return view('pages.v3.shop.index', [
            'packs' => $packs,
            'categories' => $categories
        ]);
    }

    public function show(Request $request, $id)
    {
        if(! SiteHelper::featureEnabled('shop')) {
            return view('pages.v3.shop.disabled');
        }

        $pack = $this->client->shopItem($id);

        if($pack->isCollection()) {
            return view('pages.v3.shop.show-collection', [
                'package' => $pack
            ]);
        }

        return view('pages.v3.shop.show-single', [
            'package' => $pack
        ]);
    }

    public function orders()
    {
        return redirect(route('user.order-history', auth()->user()->id));
    }

    public function purchase(Request $request, $id)
    {
        $response = $this->client->purchaseShopItem($id, $request->input('character_id', null));

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

        return redirect()->back();
    }
}