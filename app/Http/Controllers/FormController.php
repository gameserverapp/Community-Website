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
            $message = $e->getResponse()->getReasonPhrase();

            return redirectBackWithAlert($message, 'danger')->withInput($request->all());
        }

        $message = json_decode($response->getResponse()->getBody());

        if(!isset($message->message)) {
            $message = 'Unknown issue. Please try again later or contact the admin.';
        } else {
            $message = $message->message;
        }

        if($response instanceof ClientException) {
            return redirectBackWithAlert($message, 'danger')->withInput($request->all());
        }

        if($response instanceof ServerException) {
            return redirectBackWithAlert($message, 'danger')->withInput($request->all());
        }

        if($response->data->success) {
            return redirectBackWithAlert($response->data->success);
        }
    }

    public function submitOld(Request $request, $id)
    {
        try {
            $response = $this->client->submitForm($id, $request->only([
                'text-discord_name',
                'text-character_name',
                'text-character_first_name',
                'text-character_last_name',
                'text-character_class',
                'textarea-character_backstory',
                'textarea-previous_roleplay_experience'
            ]));

            if(isset($response->data)) {
                return redirectBackWithAlert($response->data);
            }

        } catch(\Exception $e) {
            $message = $e->getResponse()->getReasonPhrase();

            return redirectBackWithAlert($message, 'danger')->withInput($request->all());
        }

        $message = json_decode($response->getResponse()->getBody());

        if(!isset($message->message)) {
            $message = 'Unknown issue';
        } else {
            $message = $message->message;
        }

        if($response instanceof ClientException) {
            return redirectBackWithAlert($message, 'danger')->withInput($request->all());
        }

        if($response->data->success) {
            return redirectBackWithAlert($response->data->success);
        }

    }
}