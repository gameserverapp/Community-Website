<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GameserverApp\Api\Client;
use GameserverApp\Helpers\SiteHelper;

class CharacterController extends Controller
{
    private $api;
    
    public function __construct()
    {
        $this->api = app(Client::class);
    }
    
    public function show(Request $request, $id)
    {
        if(! SiteHelper::featureEnabled('character_page')) {
            return view('pages.v3.character.disabled');
        }

        $stats = [];

        $character = $this->api->character($id);

        if( $hoursplayed = $this->api->stats('character', 'hours-played', $id) ) {
            $stats['Online'] = (array) $hoursplayed;
        }

        if($character->hasGame() and $character->game->supportLevel()) {
            if( $levelsGained = $this->api->stats('character', 'levels-gained', $id) ) {
                $stats['Level progress'] = (array) $levelsGained;
            }

            if( $expAmount = $this->api->stats('character', 'xp-gained', $id) ) {
                $stats['EXP progress'] = (array) $expAmount;
            }
        }


        return view('pages.v3.character.index', [
            'character' => $character,
            'stats' => $stats
        ]);
    }
}