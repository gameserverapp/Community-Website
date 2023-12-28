<?php
use GameserverApp\Helpers\SiteHelper;
?>

@extends('layouts.v3.default', [
    'page' => [
        'title' => translate('inspector', 'Inspector'),
        'description' => 'Search all characters and groups on the community.',
        'class' => 'inspector'
    ],

    'breadcrumbs' => [
        [
            'title' => translate('inspector', 'Inspector')
        ]
    ]
])

@section('page_content')

    <form method="get" action="{{route('inspector.index')}}">
        <div class="row">

            <div class="col-sm-12 text-center">
                {{--                    <h3 class="title">{{translate('search', 'Search')}}:</h3>--}}
                <input type="text" class="form-control search" name="search" value="{{request('search')}}" placeholder="Search for..." autofocus>
            </div>

        </div>

        <div class="row">

            <div class="col-sm-9">

                <h5>
                    Found {{$results->total()}}
                    @if( $results->total() == 1 )
                        result
                    @else
                        results
                    @endif
                </h5>

                <?php
                $chunkSize = 2;

                if ($results->first() instanceof GameserverApp\Models\Group) {
                    $chunkSize = 2;
                }
                ?>

                @forelse( $results->chunk($chunkSize) as $chunks )
                    <div class="row">
                        @foreach($chunks as $result)
                            @if( $result instanceof GameserverApp\Models\Character)
                                <div class="col-sm-6 results">
                                    @include('partials.v3.character-card', [
                                        'character' => $result
                                    ])
                                </div>
                            @endif

                            @if( $result instanceof GameserverApp\Models\Group)
                                <div class="col-sm-6 results">
                                    @include('partials.v3.group-card', [
                                        'group' => $result
                                    ])
                                </div>
                            @endif
                        @endforeach
                    </div>
                @empty
                    <div class="col-md-6 center-block">
                        <br>
                        <div class="text-center">
                            <h2>No results...</h2>
                            <p>
                                Try something else!
                            </p>
                        </div>
                    </div>
                @endforelse

                @if( method_exists($results, 'links') )
                    <div class="paginate">
                        {{$results->appends(Request::except('page'))->links()}}
                    </div>
                @endif
            </div>

            <div class="col-sm-3">
                <h5>Filters</h5>

                @component('partials.v3.frame', ['type' => 'basic'])
                    @include('pages.v3.inspector._filters')
                @endcomponent

                @include('partials.v3.button', [
                    'type' => 'submit',
                    'element' => 'button',
                    'title' => translate('search', 'Search'),
                    'class' => 'center'
                ])
            </div>

        </div>
    </form>



@endsection