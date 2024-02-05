<?php
use GameserverApp\Helpers\SiteHelper;
?>

<header>
    <div class="row display-table">
        <div class="col-md-12 table-cell">

            <div class="row display-table">
                <div class="col-sm-4 col-lg-3 logo table-cell text-center">
                    <img src="{{$user->avatar()}}">
                </div>
                <div class="col-sm-8 col-lg-9 title table-cell">
                    <h1 class="main-title">{!! $user->showName() !!}</h1>

                    <div class="meta">
                        <div class="founded">
                            Joined {{$user->date('created_at')->format('F Y')}}
                        </div>

                        @if( $user->hoursPlayed() > 0.5 )
                            <span class="divider">|</span>

                            <div class="hours-played">
                                Played <strong>{{$user->hoursPlayed()}} hours</strong>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>

    </div>

    <?php

    $menu = [];

    if(SiteHelper::featureEnabled('user_page')) {
        $menu = [
            [
                'title' => 'Activity',
                'route' => route('user.activity', $user->id)
            ]
        ];
    }

    if ($user->hasCharacters()) {
        $characters = $user->characters->map(function ($char) {
            $name = '<span class="char_pic" style="background-image:url(' . $char->image() . ')"></span>' . $char->showName();

            if ($char->hasServer()) {
                $name .= $char->server->displayLabel();
            }

            return [
                'title' => $name,
                'route' => route('character.show', $char->id)
            ];
        });

        if(SiteHelper::featureEnabled('character_page')) {
            $menu[] = [
                'title'    => 'Characters',
                'dropdown' => $characters
            ];
        }

        $groups = $user->characters->filter(function($character) {
            return $character->hasGroup();
        })->flatMap(function ($char) {
            return $char->groups;
        })->unique(function($item) {
            return $item->id;
        })->map(function($item) {
            return [
                'title' => $item->name . ' ' . $item->displayServerClusterLabel(),
                'route' => route('group.show', $item->id)
            ];
        });


        if(
            SiteHelper::featureEnabled('tribe_page') and
            $groups->count()
            ) {
            $menu[] = [
                'title'    => 'Groups',
                'dropdown' => $groups
            ];
        }
    }

    $right = [];

    if (
        ! auth()->check() or
        (
            auth()->user()->canSendTokens() and
            !in_array($user->id, auth()->user()->subUserIds())
        )
    ) {
        $right[] = [
            'title' => 'Send tokens',
            'route' => route('token.send', $user->id)
        ];
    }

    if (
        ! auth()->check() or
        (
            auth()->user()->canSendMessage() and
            !in_array($user->id, auth()->user()->subUserIds())
        )
    ) {
        $right[] = [
            'title' => 'Send message',
            'route' => route('message.create', $user->id)
        ];
    }

    if (
        auth()->check() and
        in_array($user->id, auth()->user()->subUserIds())
    ) {

        if (SiteHelper::featureEnabled('messages')) {

            $right[] = [
                'title'    => 'Messages <span class="badge">' . auth()->user()->unreadMessagesCount() . '</span>',
                'route'    => [
                    route('message.inbox', auth()->id()),
                    route('message.outbox', auth()->id()),
                    '/user/' . auth()->id() . '/message*'
                ],
                'dropdown' => [
                    [
                        'title' => 'Inbox <span class="badge">' . auth()->user()->unreadMessagesCount() . '</span>',
                        'route' => route('message.inbox', auth()->id())
                    ],
                    [
                        'title' => 'Outbox',
                        'route' => route('message.outbox', auth()->id())
                    ]
                ]
            ];
        }

        if (SiteHelper::featureEnabled('tokens')) {

            $dropdown = [
                [
                    'title' => 'Transactions',
                    'route' => route('token.index', auth()->id())
                ]
            ];

            if (SiteHelper::featureEnabled('supporter_tiers')) {
                $dropdown[] = [
                    'title' => 'Get tokens',
                    'route' => GameserverApp\Helpers\RouteHelper::token()
                ];
            }

            $right[] = [
                'title'    => 'Tokens <span class="badge">' . auth()->user()->tokenBalance() . '</span>',
                'route'    => route('token.index', auth()->id()),
                'dropdown' => $dropdown
            ];
        }

        if (SiteHelper::featureEnabled('shop')) {

            $right[] = [
                'title' => 'Deliveries',
                'route' => route('user.deliveries', $user->id)
            ];
        }

        $right[] = [
            'title' => 'Subscriptions',
            'route' => route('subscription.index', $user->id)
        ];

        $right[] = [
            'title' => 'Invoices',
            'route' => route('user.invoices', $user->id)
        ];

        $right[] = [
            'title' => 'Settings',
            'route' => route('user.settings', $user->id)
        ];
    }
    ?>

    @include('partials.v3.custom-nav', [
        'menu' => $menu,
        'right' => $right
    ])

</header>