<?php
use GameserverApp\Helpers\SiteHelper;
?>

<header>
    <div class="row display-table">
        <div class="col-md-12 table-cell">

            <div class="row display-table">
                <div class="col-sm-4 col-lg-3 logo table-cell text-center">
                    <img src="{{$character->image()}}">
                </div>
                <div class="col-sm-8 col-lg-9 title table-cell">
                    <h1 class="main-title">{!! $character->showName() !!}</h1>

                    <div class="meta">

                        @if(
                            SiteHelper::featureEnabled('player_stats') and
                            $character->game->supportLevel()
                        )
                            <div class="level">
                                Level <strong>{{$character->level}}</strong>
                            </div>
                            <span class="divider">|</span>
                        @endif

                        @if(SiteHelper::featureEnabled('player_status'))
                            <div class="current-status">
                                @if($character->online())
                                    Online since
                                @else
                                    Last seen
                                @endif

                                @if( !is_null( $character->status_since ) )
                                    {{$character->date('status_since')->diffForHumans()}}
                                @else
                                    Never
                                @endif
                            </div>
                            <span class="divider">|</span>
                        @endif

                        @if(
                            SiteHelper::featureEnabled('player_stats') and
                            $character->hoursPlayed() > 0.5
                        )

                            <div class="hours-played">
                                Played <strong>{{$character->hoursPlayed()}} hours</strong>
                            </div>
                            <span class="divider">|</span>
                        @endif

                        <div class="related">
                            @if($character->hasServer())
                                {!! $character->server->displayLabel() !!}
                            @endif
                        </div>

{{--                        <span class="divider">|</span>--}}

{{--                        <div class="founded">--}}
{{--                            Created {{$character->date('created_at')->format('F Y')}}--}}
{{--                        </div>--}}


                    </div>
                </div>
            </div>
        </div>

    </div>

    <?php
    $menu = [];

    if(SiteHelper::featureEnabled('player_about')) {
        $menu[] = [
            'title' => 'About',
            'route' => route('character.about', $character->id)
        ];
    }

    if(SiteHelper::featureEnabled('player_stats')) {
        $menu[] = [
            'title' => 'Statistics',
            'route' => route('character.statistics', $character->id)
        ];
    }

    $right = [];

    if(SiteHelper::featureEnabled('tribe_page')) {

        if($character->hasGroup()) {
            $groups = $character->groups->map(function($group) {
                return [
                    'title' => $group->name(),
                    'route' => route('group.show', $group->id)
                ];
            });

            if($groups->count() == 1) {
                $right[] = $groups->first();
            } else {
                $right[] = [
                    'title' => 'Groups',
                    'dropdown' => $groups->toArray()
                ];
            }
        }
    }

    if($character->hasUser()) {

        $characters = false;

        if(
            $character->user->hasCharacters() or
            (
                $character->user->hasCharacters() and
                count($character->user->characters) == 1
            )
        ) {

            $characters = $character->user->characters->filter(function($char) use ($character) {
                return $char->id != $character->id;
            })->map(function($char) {
                $name = '<span class="char_pic" style="background-image:url(' . $char->image() . ')"></span>' . $char->showName();

                if($char->hasServer()) {
                    $name .= $char->server->displayLabel();
                }

                return [
                    'title' => $name,
                    'route' => route('character.show', $char->id)
                ];
            });

            if($characters->count()) {
                $characters->prepend([
                    'type' => 'separator'
                ]);
            }
        }

        $dropdown = [
            [
                'title' => 'Account profile',
                'route' => route('user.show', $character->user->id)
            ]
        ];

        if(
            !auth()->check() or
            (
                auth()->user()->canSendMessage() and
                $character->user->id != auth()->id()
            )
        ) {
            $dropdown[] = [
                'title' => 'Send message',
                'route' => route('message.create', $character->user->id)
            ];

            if(
                ! $character->hasGroup() and
                auth()->check() and
                auth()->user()->hasGroup() and
                auth()->user()->canSendMessage()
            ) {
                $dropdown[] = [
                    'type' => 'separator'
                ];

                if(
                    $character->hasServer() and
                    auth()->user()->hasGroup($character->server) and
                    auth()->user()->characterOnServer($character->server)
                ) {
                    $dropdown[] = [
                        'title' => 'Invite <u>' . $character->name() . '</u> to <u>' . auth()->user()->characterOnServer($character->server)->groupForServer($character->server)->name . '</u>',
                        'route' => route('message.create', $character->user->id)
                    ];
                } else {
                    $dropdown[] = [
                        'title' => 'Start group on <u>' . $character->server->name() . '</u>',
                        'route' => route('message.create', $character->user->id)
                    ];
                }
            }
        }

        if(
            !auth()->check() or
            (
                auth()->user()->canSendTokens() and
                $character->user->id != auth()->id()
            )
        ) {
            $dropdown[] = [
                'title' => 'Send tokens',
                'route' => route('token.send', $character->user->id)
            ];
        }

        if($reportRoute = GameserverApp\Helpers\RouteHelper::report()) {
            $dropdown[] = [
                'title' => 'Report this player',
                'route' => $reportRoute . '?report_player=' . $character->id
            ];
        }

        if($characters) {
            $dropdown = array_merge($dropdown, $characters->toArray());
        }

        $right[] = [
            'title' => $character->user->showName(),
            'dropdown' => $dropdown
        ];
    }

    ?>

    @include('partials.v3.custom-nav', [
        'menu' => $menu,
        'right' => $right
    ])

</header>