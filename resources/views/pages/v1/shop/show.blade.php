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
                            If your tribute inventory is empty, your order will be delivered in approximately 10 seconds. If your Tribute inventory is full, you will be asked to empty your Tribute inventory first. After you emptied your Tribute inventory, it should take only 1 minute to be delivered.
                        </p>
                        <p>
                            When your order is ready for pickup, you will get notified in-game!
                        </p>

                        <h3>Where to pick up the order</h3>
                        <p>
                            Every Supply crate and Obelisk gives you access to your Tribute inventory.
                        </p>

                    </div>

                </div>
            </div>

        </div>
    </div>

@stop