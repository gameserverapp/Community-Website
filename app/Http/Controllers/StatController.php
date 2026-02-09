<?php namespace App\Http\Controllers;


use GameserverApp\Generator\StatGenerator;
use Illuminate\Http\Request;

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
            'online-count-last-7-days',
            'hours-played-last-7-days',
            'new-players-last-7-days',
            'new-characters',
            'online-players',
            'hours-played'
        ];

        if(!in_array($stat, $availableStats)) {
            return response('Invalid stat', 401);
        }

        return $this->generator->basicStats(
            $request->get('value', null),
            $stat
        );
    }
}