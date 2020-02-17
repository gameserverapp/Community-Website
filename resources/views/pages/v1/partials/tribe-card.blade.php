@include('partials.frame.simple-top')
<article class="tribe-card" itemscope itemtype="http://schema.org/Organization">
    <header>

        <a class="link" href="{{route('tribe.show', $tribe->id)}}" itemprop="url">
            @if($tribe->hasServer())
                <div class="server">
                    <div class="label label-default">
                        {{$tribe->server->name()}}
                    </div>
                </div>
            @elseif($tribe->hasCluster())
                <div class="server">
                    <div class="label label-default">
                        {{$tribe->cluster->name()}}
                    </div>
                </div>
            @endif
            <div class="content">
                <h1 itemprop="name">
                    {!! $tribe->showLink(['disable_link' => true]) !!}
                </h1>
                <span class="more" >
                    More details &raquo;
                </span>
            </div>
            <div class="background">
                {!! $tribe->bannerBackground() !!}
            </div>
        </a>
    </header>
    <div class="content">
        <table class="table">
            <thead>
            <tr>
                <th>Name</th>
                @if($tribe->hasGame() and $tribe->game->supportLevel())
                    <th width="10px">Level</th>
                @endif
            </tr>
            </thead>
            <tbody>

                @if($tribe->hasMembers())
                    @foreach($tribe->members->slice(0, 4) as $character)
                        <tr>
                            <td itemprop="member">
                                {!! $character->showLink() !!}
                                @if( $character->tribeOwner($tribe) )
                                    <span class="label label-default">Owner</span>
                                @elseif($character->tribeAdmin($tribe))
                                    <span class="label label-admin">Admin</span>
                                @endif
                            </td>
                            @if($tribe->hasGame() and $tribe->game->supportLevel())
                                <td>
                                    {{$character->level}}
                                </td>
                            @endif
                        </tr>
                    @endforeach

                    @if( count($tribe->members) > 4 )
                        <tr>
                            <td colspan="4" class="text-right more">
                                <a href="{{route('tribe.show', $tribe->id)}}"
                                   onClick="ga('send', 'event', 'Button', 'click', 'See all online players');">
                                    See all {{ GameserverApp\Helpers\SiteHelper::groupName()}} members ({{count($tribe->members)}}) &raquo;
                                </a>
                            </td>
                        </tr>
                    @endif
                @endif

            </tbody>
        </table>
    </div>
</article>
@include('partials.frame.simple-bottom')