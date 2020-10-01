<?php
$image = false;

if($item->hasImage()) {
    $image = $item->image();
}
?>

@extends('layouts.v3.default', [
    'page' => [
        'title' => $item->title(),
        'description' => $item->metaDescription(),
        'class' => 'article-single',
        'attributes' => '',
        'bg' => $image
    ],
    'microdata' => [
        'content' => 'itemscope itemtype="http://schema.org/Article"'
    ],

    'breadcrumbs' => [
        [
            'title' => translate('calendar', 'Calendar'),
            'route' => route('calendar.index')
        ],
        [
            'title' => $item->title()
        ],
    ]
])

@section('page_content')

    @component('partials.v3.frame', [
        'banner' => [
            'title' => $item->title(),
            //'category' => $item->category(),
            //'date' => $item->publishedAt(),
            'image' => $item->image()
        ]
    ])
        <div class="meta">

            @foreach($item->displayLabel() as $label)
                <div class="label label-theme category">
                    {!! $label !!}
                </div>
            @endforeach

            <strong>Starts:</strong>
            <time datetime="{{$item->startAt()->toDateTimeString()}}" itemprop="datePublished">
                <span class="local-time" data-time="{{$item->start_at}}"></span>
            </time>

        </div>
        <div class="row">
            <div class="col-md-9">

                <div class="markdown-content" itemprop="articleBody">
                    {!! $item->description() !!}
                </div>

            </div>
            <div class="col-md-3">

                <div class="text-center">


                    <form class="participate-btn" method="post" action="{{route('calendar.participate', $item->id)}}">
                        {{csrf_field()}}

                        @if($item->participate)
                            <h4>
                                You joined "{{$item->title()}}"
                            </h4>
                            <button type="submit" class="btn btn-theme disabled"><span><i class="fa fa-check" aria-hidden="true"></i> Participating</span></button>
                            <p>
                                <small>
                                    <?php
                                    $otherParticipants = $item->participants - 1;
                                    ?>
                                    @if($otherParticipants == 1)
                                        Together with 1 participant
                                    @elseif($otherParticipants > 1)
                                        Together with {{$item->participants}} participants
                                    @endif
                                </small>
                            </p>
                        @else

                            <h4>
                                Join "{{$item->title()}}"
                            </h4>

                            <button type="submit" class="btn btn-theme"><span>Participate</span></button>
                            @if($item->participants > 0)
                                <p>
                                    <small>
                                        Join
                                        @if($item->participants == 1)
                                            1 other participant
                                        @elseif($item->participants > 1)
                                            {{$item->participants}} other participants
                                        @endif
                                    </small>
                                </p>
                            @endif
                        @endif
                    </form>
                </div>
            </div>
        </div>
    @endcomponent


    @include('partials.v3.hr-title', [
        'title' => translate('more_events', 'More events')
    ])

    <div class="row">
        @forelse($items as $item)
            <div class="col-md-4">
                @include('partials.v3.article-vertical', [
                    'title' => $item->title(),
                    'summary' => $item->summary(),
                    'category' => $item->displayLabel(),
                    'route' => $item->showRoute(),
                    'date' => $item->startAt(),
                    'image' => $item->image()
                ])
            </div>
        @empty
            <div class="col-md-12 text-center">
                <p>
                    <em>
                        No upcoming events yet
                    </em>
                </p>
            </div>
        @endforelse
    </div>

@stop