@extends('layouts.v2.default', [
    'page' => [
        'title' => $page['title'],
        'class' => $page['class'] . ' banner-layout',
        'description' => $page['description']
    ]
])

@section('layout_content')

    @include('layouts.v2.default.partials.banner')

    <div class="main_content">

        @yield('page_content')

    </div>

@endsection