<?php namespace App\Http\Controllers;

use App\GameserverApp\Exceptions\UploadExceededFileSizeLimitException;
use App\GameserverApp\Exceptions\UploadMimeTypeNotAcceptedException;
use App\GameserverApp\Helpers\UploadHelper;
use GuzzleHttp\Exception\ClientException;
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

        if( SiteHelper::featureEnabled('player_about')) {
            return redirect(route('character.about', $id));
        }

        if( SiteHelper::featureEnabled('player_stats')) {
            return redirect(route('character.statistics', $id));
        }

        return view('pages.v3.character.disabled');
    }
    
    public function statistics(Request $request, $id)
    {
        if(! SiteHelper::featureEnabled('character_page')) {
            return view('pages.v3.character.disabled');
        }

        if(! SiteHelper::featureEnabled('player_stats')) {
            return view('pages.v3.character.disabled');
        }

        $stats = [];

        $character = $this->api->character($id);

        if( $hoursplayed = $this->api->stats('character', 'hours-played', $id) ) {
            $stats['hours-played'] = (array) $hoursplayed;
        }

        if($character->hasGame() and $character->game->supportLevel()) {
            if( $levelsGained = $this->api->stats('character', 'levels-gained', $id) ) {
                $stats['levels-gained'] = (array) $levelsGained;
            }

            if( $expAmount = $this->api->stats('character', 'xp-gained', $id) ) {
                $stats['xp-gained'] = (array) $expAmount;
            }
        }

        return view('pages.v3.character.statistics', [
            'character' => $character,
            'stats' => $stats
        ]);
    }

    public function about(Request $request, $id)
    {
        if(! SiteHelper::featureEnabled('character_page')) {
            return view('pages.v3.character.disabled');
        }

        if(! SiteHelper::featureEnabled('player_about')) {
            return view('pages.v3.character.disabled');
        }

        $character = $this->api->character($id);

        return view('pages.v3.character.about', [
            'character' => $character
        ]);
    }

    public function aboutEdit(Request $request, $id)
    {
        if(! SiteHelper::featureEnabled('character_page')) {
            return view('pages.v3.character.disabled');
        }

        if(! SiteHelper::featureEnabled('player_about')) {
            return view('pages.v3.character.disabled');
        }

        $character = $this->api->character($id);

        if(!in_array($character->user->id, auth()->user()->allUserIds())) {
            return redirectBackWithAlert('You can not do that', 'danger');
        }

        return view('pages.v3.character.about.edit', [
            'character' => $character
        ]);
    }

    public function aboutStore(Request $request, $id)
    {
        if(! SiteHelper::featureEnabled('character_page')) {
            return view('pages.v3.character.disabled');
        }

        if(! SiteHelper::featureEnabled('player_about')) {
            return view('pages.v3.character.disabled');
        }

        $character = $this->api->character($id);

        if(!in_array($character->user->id, auth()->user()->allUserIds())) {
            return redirectBackWithAlert('You can not do that', 'danger');
        }

        try {
            $file = UploadHelper::validate($request, 'image');
        } catch (UploadExceededFileSizeLimitException $e) {
            return redirectBackWithAlert('The image you tried to upload exceeded the upload size limit.', 'danger');
        } catch (UploadMimeTypeNotAcceptedException $e) {
            return redirectBackWithAlert('The image you tried to upload is not of the supported type.', 'danger');
        }

        try {
            $this->api->saveCharacterAbout(
                $character,
                $request->input('about'),
                $file
            );
        } catch (ClientException $e) {
            return Client::exceptionToAlert($e);
        }

        return redirect(route('character.about', $character->id))->with([
            'alert' => [
                'status' => 'success',
                'message' => 'About information updated!'
            ]
        ]);
    }
}