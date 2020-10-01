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
            $content = $page->decodedContent();
        } else {
            $content = [
                [
                    'content' => [
                        [
                            'value' => Markdown::convertToHtml($page->content()),
                            'type' => 'wysiwyg',
                            'size' => 12
                        ]
                    ],
                    'settings' => [
                        'padding' => 2,
                        'vertical_align' => 'top',
                        'background_color' => 'white',
                        'background_image' => null,
                        'text-color' => 'dark'
                    ]
                ]
            ];
        }

//        dd($content);

        return view('pages.v3.page.builder', [
            'title' => $page->title(),
            'content' => $content,
            'meta' => [
                'description' => $page->metaDescription()
            ],
            'settings' => [
                'icon' => '',
                'rules' => $page->isRulePage()
            ]
        ]);
    }

    public function purge($id)
    {
        $this->client->clearCache('get', 'page/' . $id);
    }
}