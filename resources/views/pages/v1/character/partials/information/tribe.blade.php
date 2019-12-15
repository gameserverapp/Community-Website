@include('partials.frame.simple-top')
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">
            @if( $character->hasTribe() )
                <a href="{{route('tribe.view', [$character->tribe['uuid']])}}">
                    {!! tribeLink($character->tribe) !!}
                </a>

                <!--<small>
                    ({{$character->name}} is in this Tribe)
                </small>-->
            @else
                {{ ucfirst(GameserverApp\Helpers\SiteHelper::groupName())}}
            @endif
        </h3>
    </div>
    @if( $character->hasTribe() )
        <table class="table">
            <thead>
            <tr>
                <th width="40%">Name</th>
                <th></th>
                <th>Level</th>
            </tr>
            </thead>
            <tbody>

            @foreach($character->tribe->characters as $char)
                <tr>
                    <td>
                        <a href="{{route('character.view', [$char->uuid])}}">
                            <strong>
                                {!! characterName($char) !!}
                            </strong>
                        </a>
                    </td>
                    <td>
                        @if( $character->tribe->owner_id == $char->id )
                            <span class="label label-default">Owner</span>
                        @endif

                        @if(
                            auth()->check() and
                            $char->user_id == auth()->user()->id
                        )
                            <span class="label label-info">You</span>
                        @endif
                    </td>
                    <td>
                        {{$char->level}}
                    </td>
                </tr>
            @endforeach

            </tbody>
        </table>

    @else

        <div class="panel-body">
            @if(
                auth()->check() and
                auth()->user()->id == $character->user->id
            )
                Your character is not part of a {{ GameserverApp\Helpers\SiteHelper::groupName()}}
            @else
                {!! $character->showLink(['disable_link' => true]) !!} is not part of a {{ GameserverApp\Helpers\SiteHelper::groupName()}}!
            @endif
        </div>

        @if(
            auth()->check() and
            auth()->user()->id != $character->user->id and
            auth()->user()->hasTribe()
        )
            @if(
                $character->hasServer() and
                auth()->user()->hasTribe( $character->server->id ) and
                auth()->user()->characterOnServer($character->server)
            )
                <div class="panel-footer text-right">
                    <a href="{{route('message.create', $character->user->id)}}" class="btn small champ">
                        Invite {{$character->name}} to
                        "{{auth()->user()->characterOnServer($character->server)->tribe->name}}"
                        &raquo;
                    </a>
                </div>
            @else
                <div class="panel-footer text-right">
                    <a href="{{route('message.create', $character->user->id)}}" class="btn small champ">
                        Start a {{ GameserverApp\Helpers\SiteHelper::groupName()}} with {{$character->name()}} &raquo;
                    </a>
                </div>
            @endif
        @endif
    @endif
</div>
@include('partials.frame.simple-bottom')