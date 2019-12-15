<?php
namespace GameserverApp\Api\Forum;

use GuzzleHttp\Client;
use GameserverApp\Api\OAuthApi;

class Dispatcher extends \Riari\Forum\API\Dispatcher
{
    /**
     * Create a new dispatcher instance.
     *
     * @param  ReceiverContract $receiver
     */
    public function __construct(ReceiverContract $receiver)
    {
        $this->receiver = $receiver;
        $this->currentRequest = request();
    }

    public function dispatch($verb = 'GET')
    {
        $headers = OAuthApi::getHeaders(true);

        $client = new Client([
            'base_uri'   => config('gameserverapp.connection.url'),
            'headers'    => $headers,
            'exceptions' => false
        ]);

        if ($this->currentRequest->has('page')) {
            $this->parameters['page'] = $this->currentRequest->get('page');
        }

        switch ($verb) {
            case 'GET':
                $response = $client->request($verb, $this->uri, [
                    'query' => $this->parameters
                ]);
                break;

            default:
                $response = $client->request($verb, $this->uri, [
                    'form_params' => $this->parameters
                ]);
                break;
        }

        return $this->receiver->handleResponse($this->currentRequest, $response);
    }
}
