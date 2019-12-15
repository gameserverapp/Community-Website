@extends('layouts.v2.banner', [
    'page' => [
        'title' => 'Inspector ' . GameserverApp\Helpers\SiteHelper::name(),
        'description' => 'Search for all characters and tribes with an easy to use search filter!',
        'class' => 'inspector'
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
            <i class="fa fa-user-secret" aria-hidden="true"></i>
            Inspector
        </h1>
    </div>
@stop

@section('page_content')

    <div class="container">
        <div class="row defaultcontent">

            <div class="col-sm-2 filters">
                @include('pages.v1.inspector.partials.filters')
            </div>
            <div class="col-sm-10">
                <div class="row">

                    <h2 class="results__title">
                        Found {{$results->total()}}
                        @if( $results->total() == 1 )
                            result
                        @else
                            results
                        @endif
                    </h2>

                    <?php
                    $chunkSize = 2;

                    if ($results->first() instanceof GameserverApp\Models\Tribe) {
                        $chunkSize = 2;
                    }
                    ?>

                    @forelse( $results->chunk($chunkSize) as $chunks )
                        <div class="col-md-12">
                            <div class="row">
                                @foreach($chunks as $result)
                                    @if( $result instanceof GameserverApp\Models\Character)
                                        <div class="col-sm-6 results">
                                            @include('pages.v1.partials.character-card', [
                                                'character' => $result
                                            ])
                                        </div>
                                    @endif

                                    @if( $result instanceof GameserverApp\Models\Tribe)
                                        <div class="col-sm-6 results">
                                            @include('pages.v1.partials.tribe-card', [
                                                'tribe' => $result
                                            ])
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @empty
                        <div class="col-md-6 center-block">
                            <br>
                            <div class="text-center">
                                <h2>I searched everywhere!</h2>
                                <p>
                                    No results... Quick, try something else!
                                </p>
                            </div>
                        </div>
                    @endforelse

                </div>

                @if( method_exists($results, 'links') )
                    <div class="row">
                        <div class="paginate">
                            {{$results->appends(Request::except('page'))->links()}}
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </div>

@stop