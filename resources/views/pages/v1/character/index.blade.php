 @extends('layouts.v2.banner', [
    'page' => [
        'title' => $character->name() . ' (' . $character->level . ') - ' . $character->user->name() . '\'s character',
        'description' => '',
        'class' => 'character account'
    ],
    'banner' => [
        'size' => 'small',
        'animated' => true,
        'text-only' => true,
        'vertical-align' => true,
        'navigation' => 'pages.v1.character.partials.navigation',

    ]
])


@section('banner_content')
    @if(
        auth()->guest() or
        (
            auth()->check() and
            $character->user->id != auth()->id()
        )
    )
        <div class="actions">

            <div class="btn-group">
                <a href="{{route('message.create', $character->user->id)}}" class="btn small  champ">Send message</a>
                @if(auth()->check() and 1 == 2)
                    <button type="button" class="btn champ small dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="#" data-toggle="modal" data-target="#giveTokens">Give tokens</a>
                        </li>
                    </ul>
                @endif
            </div>
        </div>

    @endif

    {{--@if($character->user->character()->count() > 1)--}}
        {{--{!! accountLink($character->user) !!}'s characters--}}
    {{--@else--}}
        {!!  $character->showLink(['disable_link' => true]) !!}
    {{--@endif--}}

    {{--{!! characterName($character) !!}--}}
    {{--<span class="level">--}}
        {{--{{$character->level}}--}}
    {{--</span>--}}

@stop

@section('page_content')

    <div class="container defaultcontent">

        <div class="row">

            <div class="col-md-3 text-center picture">
                @include('pages.v1.character.partials.picture')
            </div>
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-7 statistics">
                        @include('pages.v1.character.partials.statistics')
                    </div>
                    <div class="col-md-5 information">
                        @include('pages.v1.character.partials.information')
                    </div>
                </div>

            </div>

        </div>
    </div>

    <!-- Modal -->
    @if(auth()->check() and 1 == 2)
        <div class="modal fade" id="giveTokens" tabindex="-1" role="dialog" aria-labelledby="giveTokensLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    {!! Form::open(['route'=>['token.givetoplayer', $character->user->uuid ], 'method' => 'post']) !!}

                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title" id="giveTokensLabel">
                                Give tokens to {!! accountName($character->user) !!}
                            </h4>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-info">
                                Tokens can not be returned, so be careful who you are sending your tokens to.
                            </div>

                            <p>
                                Your token balance: {{auth()->user()->displayTokenBalance()}}
                            </p>

                            <div class="form-group">
                                {!! Form::label('amount', 'Give amount:', ['for' => 'amount' ]) !!}
                                {!! Form::number('amount', 0, array('class' => 'form-control')) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('description', 'Description (optional):', ['for' => 'description' ]) !!}
                                {!! Form::textarea('description', '', array('class' => 'form-control', 'rows' => 3)) !!}
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-success">Send tokens</button>
                        </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    @endif

@stop