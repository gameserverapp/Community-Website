@extends('layouts.v3.default', [
    'page' => [
        'title' => $character->name(),
        'description' => '',
        'class' => 'character-single',
        //'bg' => $character->backgroundImage()
    ]
])

@section('page_content')
    @include('pages.v3.character._header')

    <div class="row">
        <div class="col-md-12">


            @if(isset($stats['levels-gained']) or isset($stats['xp-gained']))
                <div class="row">

                    @isset($stats['levels-gained'])
                        <div class="col-md-6">

                            @include('pages.v3.character._graph', [
                                'title' => 'Level progress',
                                'data' => $stats['levels-gained']
                            ])

                        </div>
                    @endisset

                    @isset($stats['xp-gained'])
                        <div class="col-md-6">

                            @include('pages.v3.character._graph', [
                                'title' => 'EXP progress',
                                'data' => $stats['xp-gained']
                            ])

                        </div>
                    @endisset
                </div>
            @endif

            <div class="row">
                <div class="col-md-12">

                    @include('pages.v3.character._graph', [
                        'title' => 'Hours played',
                        'data' => $stats['hours-played']
                    ])

                </div>
            </div>

        </div>
    </div>
@stop