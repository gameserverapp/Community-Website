@extends('layouts.v3.master', [
    'page' => [
        'title' => $page['title'],
        'class' => $page['class'],
        'description' => $page['description'],
        'image' => (isset($page['bg']) and $page['bg']) ? $page['bg'] : GameserverApp\Helpers\SiteHelper::background()
    ]
])

@section('layout_content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-9 col-md-10 center-block">
                <div class="main_content">

                    @isset($breadcrumbs)
                        @include('partials.v3.breadcrumbs', $breadcrumbs)
                    @endisset

                    @yield('page_content')
                </div>
            </div>
        </div>
    </div>
@stop