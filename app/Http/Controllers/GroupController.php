<?php namespace App\Http\Controllers;

use App\GameserverApp\Exceptions\UploadExceededFileSizeLimitException;
use App\GameserverApp\Exceptions\UploadMimeTypeNotAcceptedException;
use App\GameserverApp\Helpers\UploadHelper;
use Illuminate\Http\Request;
use GameserverApp\Api\Client;
use GameserverApp\Helpers\SiteHelper;

class GroupController extends Controller
{
    private $api;
    
    public function __construct()
    {
        $this->api = app(Client::class);
    }
    
    public function show(Request $request, $id)
    {
        if( !SiteHelper::featureEnabled('tribe_page')) {
            return view('pages.v3.group.disabled');
        }

        $hoursplayed = (array) $this->api->stats('group', 'hours-played', $id);

        return view('pages.v3.group.index', [
            'group' => $this->api->group($id),
            'hoursPlayed' => $hoursplayed
        ]);
    }

    public function statistics(Request $request, $id)
    {
        if(! SiteHelper::featureEnabled('tribe_page')) {
            return view('pages.v3.group.disabled');
        }

        $group = $this->api->group($id);

        $stats = [];

        $stats['hours-played'] = (array) $this->api->stats('group', 'hours-played', $id);

        if($group->hasGame() and $group->game->supportLevel()) {
            $stats['levels-gained'] = (array) $this->api->stats('group', 'levels-gained', $id);
            $stats['xp-gained'] = (array) $this->api->stats('group', 'xp-gained', $id);
        }

        return view('pages.v3.group.statistics', [
            'group' => $group,
            'stats' => $stats
        ]);
    }

    public function log(Request $request, $id)
    {
        if(! SiteHelper::featureEnabled('tribe_page')) {
            return view('pages.v3.group.disabled');
        }

        $group = $this->api->group($id);

        if(
            !auth()->check() or
            (
                auth()->check() and
                !auth()->user()->isGroupMember($group)
            )
        ) {
            return view('pages.v3.group.restricted', [
                'group' => $group
            ]);
        }

        return view('pages.v3.group.log', [
            'group' => $group,
            'logs' => $this->api->groupLog($id, route('group.log', $id), $request->get('page'))
        ]);
    }

    public function settings(Request $request, $id)
    {
        if(! SiteHelper::featureEnabled('tribe_page')) {
            return view('pages.v3.group.disabled');
        }

        $this->api->clearCache('get', 'group/' . $id . '?settings=1', []);

        $group = $this->api->group($id, [
            'settings' => true,
            'auth' => true
        ]);

        if(
            !auth()->check() or
            !auth()->user()->isGroupMember($group) or
            (
                !$group->isOwner(auth()->user()) and
                !$group->isAdmin(auth()->user())
            )
        ) {
            return view('pages.v3.group.restricted', [
                'group' => $group
            ]);
        }

        return view('pages.v3.group.settings', [
            'group' => $group
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

            case 'already-used':

                $alert = [
                    'status'  => 'danger',
                    'message' => 'This Discord server is already connected to a GSA Dashboard.'
                ];
                break;

            case 'already-used-group':

                $alert = [
                    'status'  => 'danger',
                    'message' => 'This Discord server is already connected to another group.'
                ];
                break;

            case 'failed':
                $alert = [
                    'status'  => 'danger',
                    'message' => 'Something went wrong. Please make sure all permissions are checked.'
                ];
                break;

            case 'disconnected':
                $alert = [
                    'status'  => 'success',
                    'message' => 'Your Discord information was removed.'
                ];
                break;
        }


        return redirect(route('group.settings', $id))->with([
            'alert' => $alert
        ]);
    }

    public function storeSettings(Request $request, $id)
    {
        if(! SiteHelper::featureEnabled('tribe_page')) {
            return view('pages.v1.tribe.disabled');
        }

        $group = $this->api->group($id);

        try {
            $this->api->saveGroupSettings(
                $group,
                $request->only([
                    'motd',
                    'about'
                ])
            );
        } catch (\Exception $e) {
            return Client::exceptionToAlert($e);
        }

        return redirect(route('group.settings', $group->id))->with([
            'alert' => [
                'status' => 'success',
                'message' => 'Settings saved!'
            ]
        ]);
    }

    public function storeVisual(Request $request, $id)
    {
        if(! SiteHelper::featureEnabled('tribe_page')) {
            return view('pages.v1.tribe.disabled');
        }

        $group = $this->api->group($id);

        $files = ['logo', 'background'];

        foreach($files as $name) {
            $file = false;

            try {
                $file = UploadHelper::validate($request, $name);
            } catch (UploadExceededFileSizeLimitException $e) {
                return redirectBackWithAlert('The ' . $name . ' you tried to upload exceeded the upload size limit.', 'danger');
            } catch (UploadMimeTypeNotAcceptedException $e) {
                return redirectBackWithAlert('The ' . $name . ' you tried to upload is not of the supported type.', 'danger');
            }

            if($file) {
                try {
                    $this->api->uploadGroupVisuals($group, $name, $file);
                } catch (\Exception $e) {
                    return Client::exceptionToAlert($e);
                }
            }
        }

        return redirect(route('group.settings', $group->id))->with([
            'alert' => [
                'status' => 'success',
                'message' => 'File uploaded!'
            ]
        ]);
    }

    public function discordSetChannel(Request $request, $id)
    {
        if(! SiteHelper::featureEnabled('tribe_page')) {
            return view('pages.v3.group.disabled');
        }

        $group = $this->api->group($id);

        if($request->get('channel_id') == '-1') {
            return redirectBackWithAlert('Please select a Discord channel', 'danger');
        }

        try {
            $this->api->saveGroupDiscordChannel(
                $group,
                $request->only([
                    'channel_id'
                ])
            );
        } catch (\Exception $e) {
            return Client::exceptionToAlert($e);
        }

        return redirect(route('group.discord.status', ['uuid' => $group->id, 'status' => 'success']));
    }

    public function disconnectDiscord(Request $request, $id)
    {
        if(! SiteHelper::featureEnabled('tribe_page')) {
            return view('pages.v3.group.disabled');
        }

        $group = $this->api->group($id);

        try {
            $this->api->disconnectGroupDiscordChannel($group);
        } catch (\Exception $e) {
            return Client::exceptionToAlert($e);
        }

        return redirect(route('group.discord.status', ['uuid' => $group->id, 'status' => 'disconnected']));
    }
}