<?php namespace App\Http\Controllers;


use GameserverApp\Api\Client;

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

    public function index()
    {
        return view('pages.v1.news.index', [
            'posts' => $this->client->allNews(route('news.index'))
        ]);
    }

    public function show($id)
    {
        return view('pages.v1.news.show', [
            'post' => $this->client->news($id)
        ]);
    }
}