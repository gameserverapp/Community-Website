<?php

namespace GameserverApp\Api;

use App\Http\Controllers\SupporterTierController;
use GameserverApp\Models\Character;
use GameserverApp\Transformers\CalendarTransformer;
use GameserverApp\Transformers\DeliveryTransformer;
use GameserverApp\Transformers\Forum\PostTransformer;
use GameserverApp\Transformers\SaleTransformer;
use GameserverApp\Transformers\SubscriptionTransformer;
use GameserverApp\Transformers\SupportTierTransformer;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use GameserverApp\Models\Model;
use GameserverApp\Models\Group;
use GameserverApp\Models\User;
use GameserverApp\Transformers\CharacterTransformer;
use GameserverApp\Transformers\Forum\ThreadTransformer;
use GameserverApp\Transformers\MessageTransformer;
use GameserverApp\Transformers\NewsTransformer;
use GameserverApp\Transformers\OrderTransformer;
use GameserverApp\Transformers\PageTransformer;
use GameserverApp\Transformers\ServerTransformer;
use GameserverApp\Transformers\ShopTransformer;
use GameserverApp\Transformers\TokenTransformer;
use GameserverApp\Transformers\TransactionTransformer;
use GameserverApp\Transformers\GroupTransformer;
use GameserverApp\Transformers\UserTransformer;
use function GuzzleHttp\Psr7\build_query;

class Client
{

    public function me()
    {
        return UserTransformer::transform(
            $this->api()->authRequest('get', 'user/me')
        );
    }

    public function forumSubscribe($threadId)
    {
        try {
            $response = $this->api()->authRequest('post', 'user/me/forum/subscribe/' . $threadId);

            if(isset($response->data->success) and $response->data->success == true) {
                return true;
            }
        } catch(\Exception $e) {

        }

        return false;
    }

    public function forumUnsubscribe($threadId)
    {
        try {
            $response = $this->api()->authRequest('post', 'user/me/forum/unsubscribe/' . $threadId);

            if(isset($response->data->success) and $response->data->success == true) {
                return true;
            }
        } catch(\Exception $e) {

        }

        return false;
    }

    public function forumIsSubscribed($threadId)
    {
        try {
            $response = $this->api()->authRequest('get', 'user/me/forum/is_subscribed/' . $threadId);


            if(isset($response->data->subscribed) and $response->data->subscribed == true) {
                return true;
            }
        } catch(\Exception $e) {

        }

        return false;
    }

    public function submitForm($formId, array $formContent)
    {
        return $this->api()->authRequest('post', 'form/' . $formId, [
            'form_params' => $formContent
        ]);
    }

    public function submitReport($content)
    {
        return $this->api()->authRequest('post', 'report', [
            'form_params' => $content
        ]);
    }

    public function twitchDisconnect()
    {
        return $this->api()->authRequest('post', 'user/me/twitch/disconnect');
    }

    public function discordDisconnect()
    {
        return $this->api()->authRequest('post', 'user/me/discord/disconnect');
    }

    public function patreonDisconnect()
    {
        return $this->api()->authRequest('post', 'user/me/patreon/disconnect');
    }

    public function twitchSync()
    {
        return $this->api()->authRequest('post', 'user/me/twitch/sync');
    }

    public function allServers($status = true)
    {
        $args = [];

        if($status) {
            $args['query']['status'] = true;
        }

        return ServerTransformer::transformMultiple(
            $this->api()->guestRequest('get', 'servers', $args)
        );
    }

    public function server($id)
    {
        $server = $this->api()->guestRequest('get', 'server/' . $id, [], 1);

        if(!isset($server->id)) {
            return false;
        }

        return ServerTransformer::transform($server);
    }

    public function serverClaimVote($id)
    {
        return $this->api()->authRequest('post', 'server/' . $id . '/claim-vote');
    }

    public function characters($sub = false)
    {
        if ($sub) {
            $characters = $this->api()->guestRequest('get', 'characters/' . $sub);
        } else {
            $characters = $this->api()->guestRequest('get', 'characters');
        }

        if(isset($characters->total_online)) {
            $totalOnline = $characters->total_online;

            unset($characters->total_online);

            return (object) [
                'characters' => CharacterTransformer::transformMultiple($characters),
                'totalOnline' => $totalOnline
            ];
        }

        return CharacterTransformer::transformMultiple($characters);
    }

    public function character($id)
    {
        return CharacterTransformer::transform(
            $this->api()->guestRequest('get', 'character/' . $id)
        );
    }

    public function userStats($type)
    {
        $data = $this->api()->guestRequest('get', 'user/general-stats/' . $type);

        return UserTransformer::transformMultiple($data);
    }

    public function saleStats($type)
    {
        $data = $this->api()->guestRequest('get', 'sale/stats/' . $type);

        return SaleTransformer::transformMultiple($data);
    }

    public function monthlyTarget()
    {
        return $this->api()->guestRequest('get', 'sale/stats/monthly-target');
    }

    public function saveCharacterAbout(Character $character, $about, $file = false)
    {
        $this->clearCache('get', 'character/' . $character->id, []);

        if($file) {
            return $this->api()->authRequest('post', 'character/' . $character->id . '/about', [
                'multipart' => [
                    [
                        'name' => 'about',
                        'contents' => $about
                    ],
                    [
                        'name'     => 'file',
                        'contents' => fopen($file, 'r'),
                        'filename' => $file->getClientOriginalName() . '.' . $file->getExtension()
                    ]
                ]
            ]);
        } else {
            return $this->api()->authRequest('post', 'character/' . $character->id . '/about', [
                'form_params' => [
                    'about' => $about
                ]
            ]);
        }
    }

    public function group($id, $with = [])
    {
        $query = '';

        if(count($with)) {
            $queryWith = $with;
            unset($queryWith['auth']);

            $query = '?' . http_build_query($queryWith);
        }

        if(isset($with['auth']) and $with['auth']) {
            return GroupTransformer::transform(
                $this->api()->authRequest('get', 'group/' . $id . $query)
            );
        }

        return GroupTransformer::transform(
            $this->api()->guestRequest('get', 'group/' . $id . $query)
        );
    }

    public function user($id)
    {
        return UserTransformer::transform(
            $this->api()->guestRequest('get', 'user/' . $id)
        );
    }

    public function userActivity($id, $page = 1)
    {
        $data = $this->api()->guestRequest('get', 'user/' . $id . '/activity?page=' . $page);

        $user = $data->user;
        unset($data->user);

        $data->items = PostTransformer::transformMultiple($data->items);

        return [
            'user' => UserTransformer::transform($user),
            'activity' => $this->paginatedResponse($data)
        ];
    }

    public function updateUser($id, $data)
    {
        return $this->api()->authRequest('post', 'user/' . $id . '/settings', [
            'form_params' => $data,
            'no_404_exception' => true
        ]);
    }

    public function groupLog($id, $route, $page = 1)
    {
        $response = $this->api()->authRequest('get', 'group/' . $id . '/log?page=' . $page, [], 2);

        if(!isset($response->items)) {
            return new LengthAwarePaginator(
                [],
                0,
                8,
                0,
                [
                    'path' => $route
                ]
            );
        }

        return $this->paginatedResponse($response, $route);
    }
    
    public function messages($box, $route)
    {
        $response = $this->api()->authRequest('get', 'messages/' . $box . '?page='. request('page', 1), [], false);

        if(!isset($response->items)) {
            return new LengthAwarePaginator(
                [],
                0,
                8,
                0,
                [
                    'path' => $route
                ]
            );
        }

        $response->items = MessageTransformer::transformMultiple($response->items);

        return $this->paginatedResponse($response, $route);
    }

    public function message($id)
    {
        return MessageTransformer::transform($this->api()->authRequest('get', 'message/' . $id));
    }

    public function page($id, $args = false)
    {
//        $suffix = '';
//
//        if($args) {
//            $suffix = '?' . build_query();
//        }

        return PageTransformer::transform($this->api()->guestRequest('get', 'page/' . $id, [
            'query' => $args
        ]));
    }

    public function news($id)
    {
        return NewsTransformer::transform($this->api()->guestRequest('get', 'news/' . $id, [], 2));
    }

    public function calendarFeed($start, $end)
    {
        return $this->api()->guestRequest('get', 'calendar-feed?start=' . $start . '&end=' . $end, [], 2);
    }

    public function calendar($id)
    {
        return CalendarTransformer::transform($this->api()->authRequest('get', 'calendar/' . $id, [], 2));
    }

    public function participateCalendarEvent($id)
    {
        $this->clearCache('get', 'calendar/' . $id);

        return $this->api()->authRequest('post', 'calendar/' . $id . '/participate');
    }

    public function relatedNews($id)
    {
        return NewsTransformer::transformMultiple(
            $this->api()->guestRequest('get', 'news/' . $id . '/related', [], 2)
        );
    }

    public function relatedCalendarEvents($id)
    {
        return CalendarTransformer::transformMultiple(
            $this->api()->guestRequest('get', 'calendar/' . $id . '/related', [], 2)
        );
    }

    public function allNews($route, $args = [])
    {
        $response = $this->api()->guestRequest('get', 'news?' . build_query($args), [], 2);

        if(!isset($response->items)) {
            return new LengthAwarePaginator(
                [],
                0,
                8,
                0,
                [
                    'path' => $route
                ]
            );
        }

        $response->items = NewsTransformer::transformMultiple($response->items);

        return $this->paginatedResponse($response, $route);
    }

    public function latestNews()
    {
        $response = $this->api()->guestRequest('get', 'news/latest', [], 2);

        if(isset($response->data) and !count($response->data)) {
            return [];
        }

        return NewsTransformer::transformMultiple($response);
    }

    public function latestForumThreads()
    {
        $response = $this->api()->guestRequest('get', 'forum/thread/latest');

        if(isset($response->data) and !count($response->data)) {
            return [];
        }

        return ThreadTransformer::transformMultiple($response);
    }

    public function token($id)
    {
        return TokenTransformer::transform($this->api()->guestRequest('get', 'token/' . $id));
    }

    public function allTokens($route)
    {
        $response = $this->api()->guestRequest('get', 'token');

        if(!isset($response->items)) {
            return new LengthAwarePaginator(
                [],
                0,
                8,
                0,
                [
                    'path' => $route
                ]
            );
        }

        $response->items = TokenTransformer::transformMultiple($response->items);

        return $this->paginatedResponse($response, $route);
    }

    public function supporterTier($id)
    {
        return SupportTierTransformer::transform($this->api()->guestRequest('get', 'supporter-tier/' . $id));
    }

    public function allSupporterTiers($route, $page = 1)
    {
        $response = $this->api()->guestRequest('get', 'supporter-tier?page=' . $page);

        if(!isset($response->items)) {
            return new LengthAwarePaginator(
                [],
                0,
                8,
                0,
                [
                    'path' => $route
                ]
            );
        }

        $response->items = SupportTierTransformer::transformMultiple($response->items);

        return $this->paginatedResponse($response, $route);
    }

    public function allUserTransactions($route)
    {
        $response = $this->api()->authRequest('get', 'user/me/transactions?page=' . request()->get('page', null), [], false);

        if(!isset($response->items)) {
            return new LengthAwarePaginator(
                [],
                0,
                8,
                0,
                [
                    'path' => $route
                ]
            );
        }

        $response->items = TransactionTransformer::transformMultiple($response->items);

        return $this->paginatedResponse($response, $route);
    }

    public function allUserSubscriptions($route)
    {
        $response = $this->api()->authRequest('get', 'user/me/subscriptions?page=' . request()->get('page', null), [], false);

        if(!isset($response->items)) {
            return new LengthAwarePaginator(
                [],
                0,
                8,
                0,
                [
                    'path' => $route
                ]
            );
        }

        $response->items = SubscriptionTransformer::transformMultiple($response->items);

        return $this->paginatedResponse($response, $route);
    }

    public function changeSubscriptionCharacter($uuid, $characterId)
    {
        return $this->api()->authRequest('post', 'user/me/subscriptions/' . $uuid . '/change_character', [
            'form_params' => [
                'character_id' => $characterId
            ]
        ]);
    }

    public function cancelSubscription($uuid)
    {
        return $this->api()->authRequest('post', 'user/me/subscriptions/' . $uuid . '/cancel');
    }

    public function shopItems($route, $query = [])
    {
        $query = array_merge($query, [
            'page' => request()->get('page', null),
            'cluster' => request()->get('cluster', null),
            'gameserver' => request()->get('gameserver', null),
            'filter' => request()->get('filter', null),
            'search' => request()->get('search', null),
        ]);

        $response = $this->api()->authRequest('get', 'shop', [
            'query' => $query
        ], false);

        if(!isset($response->items)) {
            return new LengthAwarePaginator(
                [],
                0,
                12,
                0,
                [
                    'path' => $route
                ]
            );
        }

        $response->items = ShopTransformer::transformMultiple($response->items);

        return $this->paginatedResponse($response, $route);
    }

    public function shopItem($id)
    {
        return ShopTransformer::transform($this->api()->authRequest('get', 'shop/' . $id, [], false));
    }

    public function purchaseShopItem($id, $characterId)
    {
        $this->api()->clearCache('get', 'shop/' . $id, [], true);
        $this->api()->clearCache('get', 'shop', [], true);

        return $this->api()->authRequest('post', 'shop/' . $id . '/purchase',[
            'form_params' => [
                'character_id' => $characterId
            ]
        ]);
    }

    public function shopOrders($route)
    {
        $response = $this->api()->authRequest('get', 'user/me/orders?page=' . request()->get('page', null));

        if(!isset($response->items)) {
            return new LengthAwarePaginator(
                [],
                0,
                8,
                0,
                [
                    'path' => $route
                ]
            );
        }

        $response->items = OrderTransformer::transformMultiple($response->items);

        return $this->paginatedResponse($response, $route);
    }

    public function deliveries($route)
    {
        $response = $this->api()->authRequest('get', 'user/me/deliveries?page=' . request()->get('page', null), [], false);

        if(!isset($response->items)) {
            return new LengthAwarePaginator(
                [],
                0,
                8,
                0,
                [
                    'path' => $route
                ]
            );
        }

        $response->items = DeliveryTransformer::transformMultiple($response->items);

        return $this->paginatedResponse($response, $route);
    }

    public function sendMessage($receiverId, $subject, $content)
    {
        return $this->api()->authRequest('post', 'message/send/' . $receiverId, [
            'form_params' => [
                'subject' => $subject,
                'content' => $content
            ]
        ]);
    }

    public function saveGroupSettings(Group $group, $data)
    {
        $this->clearCache('get', 'group/' . $group->id, []);
        $this->clearCache('get', 'group/' . $group->id . '?settings=1', []);

        return $this->api()->authRequest('post', 'group/' . $group->id . '/settings', [
            'form_params' => $data
        ]);
    }

    public function uploadGroupVisuals(Group $group, $type, UploadedFile $file)
    {
        $this->clearCache('get', 'group/' . $group->id, []);
        $this->clearCache('get', 'group/' . $group->id . '?settings=1', []);

        return $this->api()->authRequest('post', 'group/' . $group->id . '/upload/' . $type, [
            'multipart' => [
                [
                    'name'     => 'file',
                    'contents' => fopen($file, 'r'),
                    'filename' => $file->getClientOriginalName() . '.' . $file->getExtension()
                ]
            ]
        ]);
    }

    public function saveGroupDiscordChannel(Group $group, $data)
    {
        return $this->api()->authRequest('post', 'group/' . $group->id . '/discord', [
            'form_params' => $data
        ]);
    }

    public function disconnectGroupDiscordChannel(Group $group)
    {
        return $this->api()->authRequest('post', 'group/' . $group->id . '/discord/disconnect');
    }

    public function clearCache($method, $route, $options = [])
    {
        $this->api()->clearCache($method, $route, $options, true);
        $this->api()->clearCache($method, $route, $options);

        $this->api()->clearCache($method, $route, [
            'query' => $options
        ], true);
        
        $this->api()->clearCache($method, $route, [
            'query' => $options
        ]);
    }

    public function clearAllCacheForSite()
    {
        $this->api()->clearAllCache();
    }

    public function myContacts()
    {
        return UserTransformer::transformMultiple(
            $this->api()->authRequest('get', 'messages/contacts')
        );
    }

    public function kickUser()
    {
        return $this->api()->authRequest('post', 'user/me/kick');
    }

    public function confirmEmail($code)
    {
        return $this->api()->authRequest('post', 'user/me/confirm_email', [
            'form_params' => [
                'code' => $code
            ]
        ]);
    }

    public function resendConfirmEmail()
    {
        return $this->api()->authRequest('post', 'user/me/confirm_email/resend');
    }

    public function acceptRules()
    {
        return $this->api()->authRequest('post', 'user/me/accept_rules');
    }

    public function spotlight($type = false)
    {
        switch ($type) {
            case 'group':
                return GroupTransformer::transformMultiple(
                    $this->api()->guestRequest('get', 'groups/spotlight')
                );

            case 'character':
                return CharacterTransformer::transformMultiple(
                    $this->api()->guestRequest('get', 'characters/spotlight')
                );

            default:
                throw new \Exception('Unknown type');
        }
    }

    public function stats($model, $type, $id = false)
    {
        if($model == 'tribe') {
            $model = 'group';
        }

        if(!$id) {
            $url = $model . '/stats/'. $type;
        } else {
            $url = $model . '/' . $id . '/stats/'. $type;
        }

        $stat = $this->api()->guestRequest('get', $url);

        return graphColorTweak($stat);
    }

    public static function domain($key = false, $default = null)
    {
        $settings = app(OAuthApi::class)->guestRequest('get', 'domain/settings', [
//            'no_404_exception' => true
        ], 60);

        try {
            if ($key) {
                if (isset($settings->{$key})) {
                    return $settings->{$key};
                }

                return $default;
            }

            return $settings;

        } catch( \Exception $e) {
            return [];
        }
    }

    public static function verifyDomain($code)
    {
        return app(OAuthApi::class)->guestRequest('post', 'domain/verify', [
            'form_params' => [
                'code' => $code
            ]
        ]);
    }

    public function search(array $options)
    {
        $response = $this->api()->guestRequest('get', 'search', [
            'query' => $options
        ]);

        if(!isset($response->items)) {
            return new LengthAwarePaginator(
                [],
                0,
                8,
                0,
                [
                    'path' => route('inspector.index')
                ]
            );
        }

        if( $options['search_type'] == 'tribe' ) {
            $items = GroupTransformer::transformMultiple($response->items);
        } else {
            $items = CharacterTransformer::transformMultiple($response->items);
        }

        $response->items = $items;

        return $this->paginatedResponse($response, route('inspector.index'));
    }

    private function api()
    {
        return app(OAuthApi::class);
    }

    private function paginatedResponse($response, $path = null)
    {
        $class = new LengthAwarePaginator(
            $response->items,
            $response->total,
            $response->per_page,
            $response->current_page,
            [
                'path' => $path
            ]
        );

        if(isset($response->clusters)) {
            $class->clusters = $response->clusters;
        }

        if(isset($response->gameservers)) {
            $class->gameservers = $response->gameservers;
        }

        if(isset($response->filters)) {
            $class->filters = $response->filters;
        }

        return $class;
    }
}