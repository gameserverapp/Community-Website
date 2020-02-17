@include('partials.frame.simple-top')
<article class="character-account-split" itemscope itemtype="http://schema.org/Person">
    <div class="row">

        <div class="col-md-5 character">
            <div>
                <a href="{{route('character.show', $character->id)}}">
                    <div class="picture_wrap" style="background-image:url('/img/character/{{$character->characterImage()}}')"></div>
                </a>
                <div class="tags">
                {{--{!! $character->user->displayRoleLabel() !!}--}}
                </div>

            </div>
        </div>

        <div class="col-md-7 account">

            {!! $character->showLink() !!}

            <div class="summary">

                @if($character->hasGame() and $character->game->supportLevel())
                    <div>
                        Level: {{$character->level}}
                    </div>
                @endif

                <div>
                    Played: {{$character->hoursPlayed()}} hours
                </div>


                @if(GameserverApp\Helpers\SiteHelper::featureEnabled('player_status'))
                    @if( $character->online() )
                        <div>
                            Online since: {{str_replace('minutes', 'min.', $character->date('status_since')->diffForHumans())}}
                        </div>
                    @else
                        <div>
                            Last online: {{$character->date('status_since')->diffForHumans()}}
                        </div>
                    @endif
                @endif

                <div>
                    Created: {{$character->date('created_at')->diffForHumans()}}
                </div>
                <div>
                    Server:
                    @if($character->hasServer())
                        {{$character->server->name()}}
                    @endif
                </div>

                <br />

                <div class="owner">
                    Owner:
                    @if($character->hasUser())
                        {!! $character->user->showLink(['limit' => 12]) !!}
                    @endif
                </div>

                <div  class="tribe @if( !$character->hasTribe() ) recruit @endif ">

                    {{ ucfirst(GameserverApp\Helpers\SiteHelper::groupName())}}:
                    @if( $character->hasTribe() )
                        <span itemprop="memberOf">
                            {!! $character->tribes[0]->showLink(['limit' => 18]) !!}
                        </span>
                    @elseif($character->hasUser())
                        <a href="{{route('message.create', $character->user->id)}}" class="recruit">
                            Recruit {{str_limit($character->name, 9, '...')}} &raquo;
                        </a>
                    @endif

                </div>

                @if($character->hasUser())
                    <div class="message-link">
                        <a href="{{route('message.create', $character->user->id)}}">Send message &raquo;</a>
                    </div>
                @endif

            </div>
        </div>

    </div>
</article>
@include('partials.frame.simple-bottom')