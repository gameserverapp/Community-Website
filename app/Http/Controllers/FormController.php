<?php namespace App\Http\Controllers;


use GrahamCampbell\Markdown\Facades\Markdown;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use Illuminate\Http\Request;
use GameserverApp\Api\Client;
use GameserverApp\Api\OAuthApi;

class FormController extends Controller
{

    /**
     * @var Client
     */
    private $client;

    /**
     * FormController constructor.
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function submit(Request $request, $id)
    {
        try {
            $response = $this->client->submitForm($id, $request->except('_token'));

            if(isset($response->data)) {
                return redirectBackWithAlert($response->data);
            }

        } catch(\Exception $e) {
            return Client::exceptionToAlert($e);
        }

        if($response->data->success) {
            return redirectBackWithAlert($response->data->success);
        }
    }
}