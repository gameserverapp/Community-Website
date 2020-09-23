@component('partials.v3.frame', ['type' => 'basic'])
    <article class="group-card" itemscope itemtype="http://schema.org/Organization">

        <div class="tag">
            @if($group->hasServer())
                <div class="label label-theme">
                    {{$group->server->name()}}
                </div>
            @elseif($group->hasCluster())
                <div class="label label-theme">
                    {{$group->cluster->name()}}
                </div>
            @endif
        </div>

        <header>
            <div class="content">
                <h1 itemprop="name">
                    {!! $group->showLink() !!}
                </h1>
                <div class="more">
                    @include('partials.v3.button', [
                        'route' => route('tribe.show', $group->id),
                        'title' => translate('more_details', 'More details'),
                        'class' => 'small'
                    ])
                </div>

            </div>


            <div class="background">
                {!! $group->bannerBackground() !!}
            </div>
        </header>
        <div class="content">
            <table class="table">
                <thead>
                <tr>
                    <th>Name</th>
                    @if($group->hasGame() and $group->game->supportLevel())
                        <th width="20px">Level</th>
                    @endif
                </tr>
                </thead>
                <tbody>

                    @if($group->hasMembers())
                        @foreach($group->members->slice(0, 4) as $character)
                            <tr>
                                <td itemprop="member">
                                    {!! $character->showLink() !!}
                                    @if( $character->tribeOwner($group) )
                                        <span class="label label-theme alternative">Owner</span>
                                    @elseif($character->tribeAdmin($group))
                                        <span class="label label-theme alternative">Admin</span>
                                    @endif
                                </td>
                                @if($group->hasGame() and $group->game->supportLevel())
                                    <td>
                                        {{$character->level}}
                                    </td>
                                @endif
                            </tr>
                        @endforeach

                        @if( count($group->members) > 4 )
                            <tr>
                                <td colspan="4" class="text-right more">
                                    <a href="{{route('tribe.show', $group->id)}}"
                                       onClick="ga('send', 'event', 'Button', 'click', 'See all online players');">
                                        See all {{ GameserverApp\Helpers\SiteHelper::groupName()}} members &raquo;
                                    </a>
                                </td>
                            </tr>
                        @endif
                    @endif

                </tbody>
            </table>
        </div>
    </article>
@endcomponent