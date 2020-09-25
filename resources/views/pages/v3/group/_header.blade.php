<header>
    <div class="row display-table">
        <div class="col-md-8 table-cell">

            <div class="row display-table">
                <div class="col-sm-4 logo table-cell">
                    <img src="{{$group->logo()}}">
                </div>
                <div class="col-sm-8 title table-cell">
                    <h1 class="main-title">{{$group->name()}}</h1>

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
                            Founded {{$group->foundedYear()}}
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
        <div class="col-md-4 table-cell actions text-right">

            @if(
                $group->hasOwners() and
                (
                    !auth()->check() or
                    (
                        auth()->user()->canSendMessage() and
                        !auth()->user()->isGroupMember($group)
                    )
                )
            )
                <a class="btn btn-theme" href="{{route('message.create', $group->owners[0])}}">
                    <span>
                        Contact owner &raquo;
                    </span>
                </a>
            @endif

        </div>

    </div>

    <?php
    $right = [];

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

    ?>

    @include('partials.v3.custom-nav', [
        'menu' => [
            [
                'title' => 'Group &nbsp; <span class="badge">' . $group->countOnlineMembers() . ' / ' . $group->memberCount() . '</span>',
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