<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GameserverApp\Api\Client;
use GameserverApp\Helpers\SiteHelper;

class TribeController extends Controller
{
    private $api;
    
    public function __construct()
    {
        $this->api = app(Client::class);
    }
    
    public function show(Request $request, $id)
    {
        if(! SiteHelper::featureEnabled('tribe_page')) {
            return view('pages.v1.tribe.disabled');
        }

        $hoursplayed = (array) $this->api->stats('tribe', 'hours-played', $id);

        return view('pages.v1.tribe.index', [
            'tribe' => $this->tribe($id),
            'hoursPlayed' => $hoursplayed
        ]);
    }

    public function statistics(Request $request, $id)
    {
        if(! SiteHelper::featureEnabled('tribe_page')) {
            return view('pages.v1.tribe.disabled');
        }

        $tribe = $this->tribe($id);

        $stats = [];

        if( $hoursPlayed = $this->api->stats('tribe', 'hours-played', $id) ) {
            $stats['Hours online'] = (array) $hoursPlayed;
        }

        if($tribe->hasGame() and $tribe->game->supportLevel()) {
            if( $levelsGained = $this->api->stats('tribe', 'levels-gained', $id) ) {
                $stats['Character level'] = (array) $levelsGained;
            }

            if( $expAmount = $this->api->stats('tribe', 'xp-gained', $id) ) {
                $stats['XP progress'] = (array) $expAmount;
            }
        }

        return view('pages.v1.tribe.statistics', [
            'tribe' => $tribe,
            'stats' => $stats
        ]);
    }

    public function members(Request $request, $id)
    {
        if(! SiteHelper::featureEnabled('tribe_page')) {
            return view('pages.v1.tribe.disabled');
        }

        return view('pages.v1.tribe.members', [
            'tribe' => $this->tribe($id),
        ]);
    }

    public function log(Request $request, $id)
    {
        if(! SiteHelper::featureEnabled('tribe_page')) {
            return view('pages.v1.tribe.disabled');
        }

        $tribe = $this->tribe($id);

        if(
            !auth()->check() or
            ( auth()->user() and !auth()->user()->isTribeMember($tribe) )
        ) {
            return view('pages.v1.tribe.restricted', [
                'tribe' => $tribe
            ]);
        }

        return view('pages.v1.tribe.log', [
            'tribe' => $tribe,
            'logs' => $this->api->tribeLog($id, route('tribe.log', $id), $request->get('page'))
        ]);
    }

    public function promote(Request $request, $id)
    {
        if(! SiteHelper::featureEnabled('tribe_page')) {
            return view('pages.v1.tribe.disabled');
        }

        return view('pages.v1.tribe.promote', [
            'tribe' => $this->tribe($id),
        ]);
    }

    public function settings(Request $request, $id)
    {
        if(! SiteHelper::featureEnabled('tribe_page')) {
            return view('pages.v1.tribe.disabled');
        }

        $tribe = $this->tribe($id, [
            'settings' => true
        ]);

        if(
            !auth()->check() or
            !auth()->user()->isTribeMember($tribe) or
            (
                !$tribe->isOwner(auth()->user()) and
                !$tribe->isAdmin(auth()->user())
            )
        ) {
            return view('pages.v1.tribe.restricted', [
                'tribe' => $tribe
            ]);
        }

        return view('pages.v1.tribe.settings', [
            'tribe' => $tribe,
            'logs' => $this->api->tribeLog($id, route('tribe.log', $id), $request->get('page'))
        ]);
    }

    public function discordStatus(Request $request, $id,  $status)
    {
        switch($status) {
            case 'success':
                $alert = [
                    'status'  => 'success',
                    'message' => 'Done! Your logs are now also reported to your Discord'
                ];
                break;

            case 'configure':
                $alert = [
                    'status'  => 'success',
                    'message' => 'Almost done! Please finalize the configurations.'
                ];
                break;
        }


        return redirect(route('tribe.settings', $id))->with([
            'alert' => $alert
        ]);
    }

    public function storeSettings(Request $request, $id)
    {
        if(! SiteHelper::featureEnabled('tribe_page')) {
            return view('pages.v1.tribe.disabled');
        }

        $tribe = $this->tribe($id);

        $response = $this->api->saveTribeSettings(
            $tribe,
            $request->only([
                'motd',
                'about'
            ])
        );
        
        if(
            $response instanceof \Exception or
            is_null($response)
        ) {
            $error = json_decode($response->getResponse()->getBody());

            return redirect()->back()->withErrors($error);
        }

        return redirect(route('tribe.settings', $tribe->id))->with([
            'alert' => [
                'status' => 'success',
                'message' => 'Settings saved!'
            ]
        ]);
    }

    public function discordSetChannel(Request $request, $id)
    {
        if(! SiteHelper::featureEnabled('tribe_page')) {
            return view('pages.v1.tribe.disabled');
        }

        $tribe = $this->tribe($id);

        $response = $this->api->saveTribeDiscordChannel(
            $tribe,
            $request->only([
                'channel_id'
            ])
        );

        if(
            $response instanceof \Exception or
            is_null($response)
        ) {
            $error = json_decode($response->getResponse()->getBody());

            return redirect()->back()->withErrors($error);
        }

        return redirect(route('tribe.discord.status', ['uuid' => $tribe->id, 'status' => 'success']));
    }

    private function tribe($id, $with = [])
    {
        return $this->api->tribe($id, $with);
    }
}