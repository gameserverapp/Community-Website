<?php
namespace GameserverApp\Api\Forum;

use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;

interface ReceiverContract
{
    /**
     * Handle a response from the dispatcher for the given request.
     *
     * @param  Request  $request
     * @param  Response  $response
     * @return Response|mixed
     */
    public function handleResponse(Request $request, Response $response);
}
