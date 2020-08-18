<?php namespace App\Http\Controllers;


use GameserverApp\Generator\StatGenerator;
use App\Http\Controllers\Forum\CategoryController;
use Illuminate\Http\Request;
use GameserverApp\Api\Client;

class StatController extends Controller
{
    private $generator;

    public function __construct()
    {
        $this->generator = app(StatGenerator::class);
    }

    public function index(Request $request, $stat)
    {
        $availableStats = [
            'online_count_last_7_days',
            'hours_played_last_7_days',
            'new_players_last_7_days',
            'new-characters',
            'online-players',
            'hours-played'
        ];

        if(!in_array($stat, $availableStats)) {
            return response('Invalid stat', 401);
        }

        return $this->generator->basicStats($request->get('value', null), $stat);
    }
}