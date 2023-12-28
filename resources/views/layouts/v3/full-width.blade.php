@extends('layouts.v3.master', [
    'page' => [
        'title' => $page['title'],
        'class' => $page['class'],
        'description' => $page['description'],
        'image' => isset($page['bg']) ? $page['bg'] : GameserverApp\Helpers\SiteHelper::background()
    ]
])

@section('layout_content')
    <div class="main_content">

        @isset($breadcrumbs)
            @include('partials.v3.breadcrumbs', $breadcrumbs)
        @endisset

        @yield('page_content')
    </div>
@endsection