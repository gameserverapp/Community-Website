@extends('layouts.v3.default', [
    'page' => [
        'title' => 'Statistics - ' . $group->name(),
        'description' => str_limit($group->about(), 200),
        'class' => 'group-single',
        'bg' => $group->backgroundImage()
    ]
])

@section('page_content')
    @include('pages.v3.group._header')

    <div class="row">
        <div class="col-md-12">

            @include('pages.v3.group._graph', [
                'title' => 'Hours played',
                'data' => $stats['hours-played']
            ])

        </div>
    </div>

    @isset($stats['levels-gained'])
        <div class="row">
            <div class="col-md-12">

                @include('pages.v3.group._graph', [
                    'title' => 'Level progress',
                    'data' => $stats['levels-gained']
                ])

            </div>
        </div>
    @endisset

    @isset($stats['xp-gained'])
        <div class="row">
            <div class="col-md-12">

                @include('pages.v3.group._graph', [
                    'title' => 'EXP progress',
                    'data' => $stats['xp-gained']
                ])

            </div>
        </div>
    @endisset
@stop