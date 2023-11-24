@extends('layouts.v3.default', [
    'page' => [
        'title' => 'Log - ' . $group->name(),
        'description' => str_limit($group->about(), 200),
        'class' => 'group-single',
        'bg' => $group->backgroundImage()
    ]
])

@section('page_content')
    @include('pages.v3.group._header')

    <div class="row">
        <div class="col-md-6 center-block">

            @component('partials.v3.frame', ['title' => 'Restricted'])

                <div class="text-center">
                    <p>You need to be part of <strong>{{$group->name()}}</strong> to access this page.</p>
                </div>

                @if(!auth()->check())


                    <br>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <a class="btn btn-theme btn-theme-rock" href="{{route('auth.login')}}">
                                <span>Login</span>
                            </a>
                        </div>
                    </div>
                @endif

            @endcomponent

        </div>
    </div>
@stop