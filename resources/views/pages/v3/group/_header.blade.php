<header>
    <div class="row display-table">
        <div class="col-md-12 table-cell">

            <div class="row display-table">
                <div class="col-sm-4 col-lg-3 logo table-cell">
                    <img src="{{$group->logo()}}">
                </div>
                <div class="col-sm-8 col-lg-9 title table-cell">
                    <h1 class="main-title">{!! $group->showName() !!}</h1>

                    <div class="meta">
                        <div class="member-count">
                            <i class="fa fa-users" aria-hidden="true"></i>
                            {{$group->memberCount()}}
                            @if($group->memberCount() == 1)
                                member
                            @else
                                members
                            @endif
                        </div>

                        <span class="divider">|</span>

                        <div class="founded">
                            Founded {{$group->foundedDate()}}
                        </div>

                        <span class="divider">|</span>

                        <div class="related">
                            @if($group->hasServer())
                                <div class="label label-theme alternative server">
                                    {{$group->server->name()}}
                                </div>
                            @elseif($group->hasCluster())
                                <div class="label label-theme alternative server">
                                    {{$group->cluster->name()}}
                                </div>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>

    <?php
    $right = [];

    if(
        $group->hasOwners() and
        (
            !auth()->check() or
            (
                auth()->user()->canSendMessage() and
                !auth()->user()->isGroupMember($group)
            )
        )
    ) {
        $right[] = [
            'title' => 'Contact owner',
            'route' => route('message.create', $group->owners[0])
        ];
    }

    if(
        auth()->check() and
        auth()->user()->isGroupMember($group)
    ) {
//        $right[] = [
//            'title' => 'Promote',
//            'route' => route('group.promote', $group->id)
//        ];

        if(
            $group->isOwner(auth()->user()) or
            $group->isAdmin(auth()->user())
        ) {
            $right[] = [
                'title' => 'Settings',
                'route' => route('group.settings', $group->id)
            ];
        }
    }


    $onlineCount = $group->countOnlineMembers();
    if($onlineCount) {
        $badgeContent = $group->countOnlineMembers() . ' / ' . $group->memberCount();
    } else {
        $badgeContent = $group->memberCount();
    }
    ?>

    @include('partials.v3.custom-nav', [
        'menu' => [
            [
                'title' => 'Group &nbsp; <span class="badge">' . $badgeContent . '</span>',
                'route' => route('group.show', $group->id)
            ],
            [
                'title' => 'Statistics',
                'route' => route('group.statistics', $group->id)
            ],
            [
                'title' => 'Log',
                'route' => route('group.log', $group->id)
            ]
        ],
        'right' => $right
    ])

</header>