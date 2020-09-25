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


{{--                        @if($character->game->supportLevel())--}}
{{--                            <div class="level">--}}
{{--                                Level <strong>{{$character->level}}</strong>--}}
{{--                            </div>--}}
{{--                            <span class="divider">|</span>--}}
{{--                        @endif--}}

{{--                        <div class="current-status">--}}
{{--                            @if($character->online())--}}
{{--                                Online since--}}
{{--                            @else--}}
{{--                                Last seen--}}
{{--                            @endif--}}

{{--                            @if( !is_null( $character->status_since ) )--}}
{{--                                {{$character->date('status_since')->diffForHumans()}}--}}
{{--                            @else--}}
{{--                                Never--}}
{{--                            @endif--}}
{{--                        </div>--}}

{{--                        @if( $character->hoursPlayed() > 0.5 )--}}
{{--                            <span class="divider">|</span>--}}

{{--                            <div class="hours-played">--}}
{{--                                Played <strong>{{$character->hoursPlayed()}} hours</strong>--}}
{{--                            </div>--}}
{{--                        @endif--}}

{{--                        <span class="divider">|</span>--}}

{{--                        <div class="related">--}}
{{--                            @if($character->hasServer())--}}
{{--                                {!! $character->server->displayLabel() !!}--}}
{{--                            @endif--}}
{{--                        </div>--}}

{{--                        <span class="divider">|</span>--}}

{{--                        <div class="founded">--}}
{{--                            Created {{$character->date('created_at')->format('F Y')}}--}}
{{--                        </div>--}}


                    </div>

                    <div class="roles">
                        <?php
                        $roles = $user->displayRoleLabel()
                        ?>
                        @if(!empty($roles))
                            {!! $roles !!}
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>

    <?php
    $menu = [
         [
             'title' => 'About',
             'route' => route('user.about', $user->id)
         ]
     ];

    if($user->hasCharacters()) {
        $characters = $user->characters->map(function($char) {
            $name = '<span class="char_pic" style="background-image:url(' . $char->image() . ')"></span>' . $char->showName();

            if($char->hasServer()) {
                $name .= $char->server->displayLabel();
            }

            return [
                'title' => $name,
                'route' => route('character.show', $char->id)
            ];
        });

        $menu[] = [
            'title' => 'Characters',
            'dropdown' => $characters
        ];

    }

    $right = [];

    if(
        !auth()->check() or
        (
            auth()->user()->canSendMessage() and
            $user->id != auth()->id()
        )
    ) {
        $right[] = [
            'title' => 'Send message',
            'route' => route('message.create', $user->id)
        ];
    }

    if(
        auth()->check() and
        $user->id == auth()->id()
    ) {

        if(SiteHelper::featureEnabled('messages')) {

            $right[] = [
                'title' => 'Messages <span class="badge">' . auth()->user()->unreadMessagesCount() . '</span>',
                'route' => [
                    route('message.inbox', auth()->id()),
                    route('message.outbox', auth()->id())
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

        if(SiteHelper::featureEnabled('tokens')) {

            $dropdown = [
                [
                    'title' => 'Transactions',
                    'route' => route('token.index', auth()->id())
                ]
            ];

            if(SiteHelper::featureEnabled('supporter_tiers')) {
                $dropdown[] = [
                    'title' => 'Get tokens',
                    'route' => route('supporter-tier.index', $user->id)
                ];
            }

            $right[] = [
                'title' => 'Tokens <span class="badge">' . auth()->user()->tokenBalance() . '</span>',
                'route' => route('token.index', auth()->id()),
                'dropdown' => $dropdown
            ];
        }

        if(SiteHelper::featureEnabled('shop')) {
            $right[] = [
                'title' => 'Orders',
                'route' => route('shop.orders', $user->id)
            ];
        }

        $right[] = [
            'title' => 'Subscriptions',
            'route' => route('subscription.index', $user->id)
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