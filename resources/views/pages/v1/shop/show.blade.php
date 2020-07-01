@extends('layouts.v2.banner', [
    'page' => [
        'title' => $pack->name(),
        'description' => 'Your ordered items are delivered in real-time! Pick it up at the nearest Supply Crate or Obelisk!',
        'class' => 'supplies single'
    ],
    'banner' => [
        'size' => 'small',
        'text-only' => false,
        'vertical-align' => true
    ]
])

@section('banner_content')

    <div class="col-md-8 text-only center-block">
        <h1>
            {{$pack->name()}}
        </h1>
    </div>
@stop

@section('page_content')

    <div class="container">
        <div class="row defaultcontent">

            <div class="col-md-8 center-block">
                <div class="row">

                    <div class="col-sm-2 image">
                        <img height="80" src="{{$pack->image()}}"
                             alt="{{$pack->name()}}">
                    </div>
                    <div class="col-sm-8">

                        @if($pack->cluster)
                            <div class="alert alert-warning">
                                <span>
                                    <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                                    Only deliverable on the <strong>{{$pack->cluster}}</strong> cluster!
                                </span>
                            </div>
                        @endif

                        <h2>
                            Your order: {{$pack->name()}}
                        </h2>

                        @include('partials.frame.simple-top')
                        <ul class="list-group">
                            <li class="list-group-item">
                                Order contents: {!! Markdown::convertToHtml($pack->description()) !!}
                            </li>

                            @if($pack->tokenPrice() > 0)
                                <li class="list-group-item">
                                    Price: <strong>{{$pack->displayTokenPrice()}}</strong>
                                </li>
                            @endif
                        </ul>
                        @include('partials.frame.simple-bottom')

                        {!! Form::open(['route'=>['shop.purchase', $pack->id], 'method' => 'order']) !!}

                        @if(auth()->check() and !$pack->isEmptyPack())
                            @if($pack->hasCharacters())
                                <div class="form-group">
                                    <label>Deliver to:</label>
                                    <select name="character_id">
                                        @foreach($pack->characters() as $character)
                                            @if($character->status)
                                                <option selected value="{{$character->id}}">{{$character->name()}} [online]</option>
                                            @else
                                                <option value="{{$character->id}}">{{$character->name()}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            @else
                                <div class="alert alert-danger">
                                    You do not have a character to deliver this shop pack to.
                                </div>
                            @endif
                        @endif

                        <div class="form-group">
                            <label class="agree_terms">
                                <span>
                                    You have <strong>7 days</strong> to pick up your order.
                                </span>
                            </label>
                        </div>

                        {!! Form::submit('Submit my order &raquo;', array('class' => 'btn champ small')) !!}
                        {!! Form::close() !!}

                        <hr>

                        <h3>When do I get it?</h3>
                        <p>
                            Your order is delivered automatically in less than 1 minute. You're alerted in-game on the status.
                        </p>

                    </div>

                </div>
            </div>

        </div>
    </div>

@stop