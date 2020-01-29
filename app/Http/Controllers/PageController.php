<?php namespace App\Http\Controllers;


use GrahamCampbell\Markdown\Facades\Markdown;
use GameserverApp\Api\Client;
use GameserverApp\Api\OAuthApi;

class PageController extends Controller
{

    /**
     * @var Client
     */
    private $client;

    /**
     * PageController constructor.
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function show($id)
    {
        $page = $this->client->page($id);

        if($page->isBuilder()) {
            $template = 'builder';
            $class = 'pagebuilder';
            $content = $page->decodedContent();
        } else {
            $template = 'default';
            $class = 'non-pagebuilder';
            $content = Markdown::convertToHtml($page->content());
        }

        return view('pages.v1.page.' . $template, [
            'title' => $page->title(),
            'content' => $content,
            'meta' => [
                'description' => ''
            ],
            'settings' => [
                'icon' => '',//'fa fa-rocket',
                'class' => $class,
                'banner' => [
                    'size' => 'small',
                    //'down-button' => true,
                    //'animated' => true,
                    'text-only' => true,
                    'vertical-align' => true
                ],
                'rules' => $page->isRulePage()
            ]
        ]);
    }

    public function purge($id)
    {
        $this->client->clearCache('get', 'page/' . $id);
    }
}