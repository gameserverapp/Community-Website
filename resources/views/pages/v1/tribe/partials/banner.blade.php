@if(
    auth()->check() and
    auth()->user()->isTribeMember($tribe) and
    1 == 2
)
    @inject('tribeRepository', 'App\Tribe\TribeRepository')

    <?php
    $tribes = $tribeRepository->getAllForUser(auth()->user());
    ?>

    @if( count( $tribes ) > 1 )
        <div class="switcher">
            <div class="btn-group">
                <div class="dropdown">
                    <button class="btn champ inverted  dropdown-toggle" id="dropdownTokens" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="true">
                        Your other {{ GameserverApp\Helpers\SiteHelper::groupName()}}s
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownTokens">
                        @foreach($tribes as $item)
                            @if($item->id != $tribe->id)
                                <li class="tribenav">
                                    <a href="{{route('tribe.view', $item->uuid)}}">
                                        {!! tribeName(
                                            $item,
                                            'small',
                                            null,
                                            ''
                                        ) !!}
                                        <span class="label label-default server">{{$item->server->name}}</span>
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif
@endif

{!! $tribe->showLink(['disable_link' => true]) !!}

@if(
    auth()->check() and
    !auth()->user()->isTribeMember($tribe) and
    $tribe->hasOwner()
 )
    <div class="promote">
        <a class="btn champ inverted small" href="{{route('message.create', $tribe->owner_id)}}">
            send application &raquo;
        </a>
    </div>
@endif