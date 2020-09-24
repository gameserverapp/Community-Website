@extends('layouts.v2.banner', [
    'page' => [
        'title' => $tribe->name(),
        'description' => '',
        'class' => 'tribe dashboard'
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


                <div class="row">

                    <div class="col-sm-6">

                        @if(auth()->check() and auth()->user()->isGroupMember($tribe))
                            @include('pages.v1.tribe.partials.motd')

                            <div class="text-center">
                                <a href="{{route('group.promote', $tribe->id)}}" class="btn champ inverted small tinytosmall">
                                    Promote your {{ GameserverApp\Helpers\SiteHelper::groupName()}} &raquo;
                                </a>
                            </div>
                            <br><br>
                        @else
                            @include('pages.v1.tribe.partials.about')
                        @endif

                    </div>

                    <div class="col-sm-6">

                        @if($tribe->hasMembers())
                            @include('pages.v1.tribe.partials.players', ['characters' => $tribe->members])
                        @endif

                    </div>

                </div>

                @if(auth()->check() and auth()->user()->isGroupMember($tribe))
                    <div class="row">

                        <div class="col-sm-12">
                            @include('pages.v1.tribe.partials.about')
                        </div>
                    </div>
                @endif

                <div class="row">

                    <div class="col-sm-12">
                        @include('pages.v1.tribe.partials.hoursplayed')
                    </div>
                </div>


            </div>
        </div>
    </div>
@stop