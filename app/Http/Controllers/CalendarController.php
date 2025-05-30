<?php namespace App\Http\Controllers;


use GameserverApp\Api\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;

class CalendarController extends Controller
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
        return view('pages.v3.calendar.index');
    }

    public function feed(Request $request)
    {
        $response = $this->client->calendarFeed(
            $request->get('start', 0),
            $request->get('end', 0)
        );

        return response()->json(
            $response->data
        );
    }

    public function show($id)
    {
        return view('pages.v3.calendar.show', [
            'item' => $this->client->calendar($id),
            'items' => $this->client->relatedCalendarEvents($id)
        ]);
    }

    public function participate($id)
    {
        try {
            $this->client->participateCalendarEvent($id);
        } catch (ClientException $e) {
            return Client::exceptionToAlert($e);
        }

        return redirectBackWithAlert('Your participation status was updated!');
    }

    public function purge($id)
    {
        $this->client->clearCache('get', 'calendar/' . $id);
    }
}