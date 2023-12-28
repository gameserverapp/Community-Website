@extends('layouts.v3.default', [
    'page' => [
        'title' => $group->name(),
        'description' => str_limit($group->about(), 200),
        'class' => 'group-single',
        'bg' => $group->backgroundImage()
    ]
])

@section('page_content')
    @include('pages.v3.group._header')

    <div class="row">
        <div class="col-md-8">

            @include('pages.v3.group._members-table')

        </div>
        <div class="col-md-4">

            <div class="row">
                <div class="col-md-12">

                    @if(
                        auth()->check() and
                        auth()->user()->isGroupMember($group)
                    )
                        @include('pages.v3.group._motd')
                    @else
                        @include('pages.v3.group._about')
                    @endif

                </div>
                <div class="col-md-12">
                    @include('pages.v3.group._graph', [
                        'title' => 'Recent activity',
                        'data' => $hoursPlayed
                    ])
                </div>
            </div>

        </div>
    </div>
@endsection