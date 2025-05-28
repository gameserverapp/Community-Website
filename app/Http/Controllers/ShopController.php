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

        $packs = $this->client->shopItems(route('shop.index'), [

        ]);

        $clusters = false;
        $gameservers = false;
        $filters = false;

        if(isset($packs->clusters)) {
            $clusters = $packs->clusters;
        }

        if(isset($packs->gameservers)) {
            $gameservers = $packs->gameservers;
        }

        if(isset($packs->filters)) {
            $filters = $packs->filters;
        }

        if($request->has('status') == 'success') {
            session()->flash('alert', [
                'status'  => 'success',
                'message' => 'Thank you for your order! Your orders is being processed.',
                'stay'    => true
            ]);
        }

        return view('pages.v3.shop.index', [
            'packs' => $packs,
            'clusters' => $clusters,
            'gameservers' => $gameservers,
            'filters' => $filters
        ]);
    }

    public function show(Request $request, $id)
    {
        if(! SiteHelper::featureEnabled('shop')) {
            return view('pages.v3.shop.disabled');
        }

        $pack = $this->client->shopItem($id);

        if($pack->isCollection()) {

            $filters = [];

            if($pack->hasChildren()) {

                foreach ($pack->children() as $child) {

                    if(!$child->hasLabel()) {
                        $filters[-1] = 'No label';
                    } else {
                        $label = $child->label(false);

                        if(!empty($label)) {
                            $filters[$label] = $label;
                        }
                    }
                }

                ksort($filters);
            }

            return view('pages.v3.shop.show-collection', [
                'package' => $pack,
                'filters' => $filters
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
        try {
            $response = $this->client->purchaseShopItem(
                $id,
                $request->input('character_id', null),
                $request->input('gameserver_id', null)
            );
        } catch (ClientException | ServerException $exception) {
            $message = json_decode($exception->getResponse()->getBody())->message;

            session()->flash('alert', [
                'status'  => 'danger',
                'message' => $message,
                'stay'    => true
            ]);

            return redirect()->back()->withInput();
        }

        session()->flash('alert', [
            'status'  => 'success',
            'message' => $response->data,
            'stay'    => true
        ]);

        return redirect()->back();
    }
}