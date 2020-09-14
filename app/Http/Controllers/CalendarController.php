<?php namespace App\Http\Controllers;


use GameserverApp\Api\Client;
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
        return view('pages.v1.calendar.index');
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
        return view('pages.v1.calendar.show', [
            'calendar' => $this->client->calendar($id)
        ]);
    }

    public function participate($id)
    {
        $response = $this->client->participateCalendarEvent($id);

        if(
            $response instanceof \Exception or
            is_null($response)
        ) {
            $error = json_decode($response->getResponse()->getBody());

            if(isset($error->message)) {
                return redirectBackWithAlert($error->message, 'danger');
            }

            return redirectBackWithAlert('Something went wrong. Please try again.', 'danger');
        }

        return redirectBackWithAlert('Your participation status was updated!');
    }
}