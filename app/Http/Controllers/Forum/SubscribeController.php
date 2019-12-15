<?php namespace App\Http\Controllers\Forum;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GameserverApp\Api\Client;
use GameserverApp\Api\OAuthApi;

class SubscribeController extends Controller
{
    private $api;

    public function __construct()
    {
        $this->api = app(Client::class);
    }

    public function subscribe(Request $request, $threadId)
    {
        try {
            $this->api->forumSubscribe($threadId);

            app(OAuthApi::class)->clearCache('get', 'user/me/forum/is_subscribed/' . $threadId, [], true);

            return redirectBackWithAlert('You are now subscribed to this thread!');
        } catch(\Exception $e) {
            return redirectBackWithAlert('Whoops, something went wrong. Please try again!', 'warning');
        }
    }

    public function unsubscribe(Request $request, $threadId)
    {
        try {
            $this->api->forumUnsubscribe($threadId);

            app(OAuthApi::class)->clearCache('get', 'user/me/forum/is_subscribed/' . $threadId, [], true);

            return redirectBackWithAlert('You are no longer subscribed to this thread!');
        } catch(\Exception $e) {
            return redirectBackWithAlert('Whoops, something went wrong. Please try again!', 'warning');
        }
    }

}