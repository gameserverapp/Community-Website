<?php namespace App\Http\Controllers;

use GameserverApp\Api\Client;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * @var Client
     */
    private $client;

    /**
     * NewsController constructor.
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function index(Request $request)
    {
        $items = $this->client->allNews(
            route('news.index'),
            [
                'page' => $request->get('page', 1),
                'skip_latest' => true
            ]
        );

        $latest = $this->client->latestNews();
        $hero = $latest->first();
        $latest->shift();

        return view('pages.v3.news.index', [
            'items' => $items,
            'latest' => $latest,
            'hero' => $hero
        ]);
    }

    public function show($id)
    {
        return view('pages.v3.news.show', [
            'item' => $this->client->news($id),
            'items' => $this->client->relatedNews($id)
        ]);
    }

    public function purge($id)
    {
        $this->client->clearCache('get', 'news');
        $this->client->clearCache('get', 'news/' . $id);
    }
}