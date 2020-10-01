@extends('layouts.v2.banner', [
    'page' => [
        'title' => 'Log - ' . $tribe->name,
        'description' => '',
        'class' => 'tribe log'
    ],
    'banner' => [
        'size' => 'small',
        'animated' => true,
        'text-only' => true,
        'vertical-align' => true,
        'navigation' => 'pages.v1.tribe.partials.navigation',
        'background' => [
            'tribe' => $tribe->bannerBackground()
        ]
    ]
])

@section('banner_content')
    @include('pages.v1.tribe.partials.banner')
@stop

@section('page_content')

    <div class="container defaultcontent">

        <div class="row">
            <div class="col-md-10 center-block">


                @if(
                    auth()->check() and
                    auth()->user()->isGroupMember($tribe) and
                    (
                        $tribe->isOwner(auth()->user()) and
                        !$tribe->discordSetup()
                    )
                )
                    <div class="alert alert-info">Read the logs on your Discord server. <a href="{{route('group.settings', $tribe->id)}}">Setup Discord &raquo;</a></div>
                @endif

                <h2>
                    Number of logs: {{$logs->total()}}
                </h2>
            </div>
        </div>

        <div class="row">
            <div class="col-md-10 center-block">
                @include('partials.frame.simple-top')
                <div class="list-group message-list">

                    @forelse($logs as $log)

                        <div class="list-group-item message-item @if($log->rgbacolor)rgba @endif">
                            <div class="row">

                                <div class="col-xs-3 col-md-2 date">
                                    {{Carbon\Carbon::parse($log->created_at)->diffForHumans()}}
                                </div>

                                <div class="col-xs-9 col-md-10 message">

                                    <span class="@if($log->richcolor) {{getRichColorClass($log->richcolor)}} @endif">
                                        {{$log->message}}
                                    </span>

                                    @if($log->date)
                                        <span class="gamedate">
                                            ({{$log->date}})
                                        </span>
                                    @endif
                                </div>

                            </div>
                        </div>
                    @empty
                        <div class="list-group-item message-item text-center">
                            <em>No logs...</em>
                        </div>
                    @endforelse

                </div>
                @include('partials.frame.simple-bottom')


                <div class="paginate">
                    {!! $logs->links() !!}
                </div>
            </div>

        </div>
    </div>

@stop