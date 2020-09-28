@component('partials.v3.frame', ['type' => 'basic'])
    <article class="group-card" itemscope itemtype="http://schema.org/Organization">

        <div class="tag">
            {!! $group->displayServerClusterLabel() !!}
        </div>

        <header>
            <div class="content">
                <h1 itemprop="name">
                    {!! $group->showLink() !!}
                </h1>
                <div class="more">
                    @include('partials.v3.button', [
                        'route' => route('group.show', $group->id),
                        'title' => translate('more_details', 'More details'),
                        'class' => 'small'
                    ])
                </div>

            </div>


            <div class="background" style="background-image:url({{$group->backgroundImage()}})"></div>
        </header>
        <div class="content">
            <table class="table table-padding table-striped">
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
                                    @if( $character->groupOwner($group) )
                                        <span class="label label-theme">Owner</span>
                                    @elseif($character->groupAdmin($group))
                                        <span class="label label-theme alternative">Manager</span>
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
                                    <a href="{{route('group.show', $group->id)}}"
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