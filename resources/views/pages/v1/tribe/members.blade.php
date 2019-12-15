@extends('layouts.v2.banner', [
    'page' => [
        'title' => 'Members ' . $tribe->name,
        'description' => '',
        'class' => 'tribe members'
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

                    @php
                        if($tribe->countAllMembers()) {
                            $members = $tribe->members;
                        } else {
                            $members = collect();
                        }
                    @endphp

                    @forelse( $members as $character )

                        <div class="col-sm-6">
                            @include('pages.v1.partials.character-card')
                        </div>
                    @empty

                        <div class="col-sm-6">
                            <em>No members found</em>
                        </div>

                    @endforelse

                </div>
            </div>
        </div>
    </div>

@stop