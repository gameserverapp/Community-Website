<?php namespace App\Http\Controllers;


use GrahamCampbell\Markdown\Facades\Markdown;
use GameserverApp\Api\Client;
use GameserverApp\Api\OAuthApi;
use Illuminate\Http\Request;
use function GuzzleHttp\Psr7\build_query;

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

    public function show(Request $request, $id, $slug = 'home')
    {
        //todo assert format is valid

        $page = $this->client->page($id, request()->only([
            'report_player'
        ]));

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

        $slug = strtolower($slug);

        return view('pages.v3.page.builder', [
            'title' => $page->title(),
            'content' => $content,
            'meta' => [
                'description' => $page->metaDescription(),
                'class' => 'page-' . $slug
            ],
            'settings' => [
                'icon' => '',
                'rules' => $page->isRulePage()
            ]
        ]);
    }

    public function purge($id)
    {
        $this->client->clearCache('get', 'page/' . $id, request()->only([
            'report_player'
        ]));
    }
}