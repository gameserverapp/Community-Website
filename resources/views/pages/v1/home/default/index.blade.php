@extends('layouts.v2.banner', [
    'page' => [
        'title' => GameserverApp\Helpers\SiteHelper::name(),
        'description' => GameserverApp\Helpers\SiteHelper::seoDescription(),
        'class' => 'home member'
    ],
    'banner' => [
        'size' => 'big',
        'down-button' => false,
    ]
])


@section('banner_content')
    @include('pages.v1.home.default.partials.banner')
@stop

@section('page_content')
    @include('pages.v1.home.default.partials.latest')

    {{--@include('pages.v2.home.shared.tips')--}}

    @include('pages.v1.home.default.partials.servers-slider')

    @include('pages.v1.home.default.partials.stats')

    @include('pages.v1.home.default.partials.spotlight')

    {{--@include('pages.v2.home.shared.youtube')--}}

    {{--@include('pages.v1.home.default.partials.news')--}}

    {{--@include('pages.v2.home.member.partials.characters')--}}

    {{--@include('pages.v2.home.member.partials.spotlight')--}}

    {{--@include('pages.v2.home.member.partials.tribes')--}}

    {{--@include('pages.v2.home.shared.stream')--}}

@stop


@section('footer_scripts')
    <script>
        var inactivityTime = function (secondsTillRefresh) {
            var t;
            window.onload = resetTimer;
            document.onmousemove = resetTimer;
            document.onkeypress = resetTimer;

            function triggerRefresh() {
                if( $('body').scrollTop() <= $('.banner').height() ) {
                    location.href = '/?autoreload=true';
                }
                console.log('triggert');
            }

            function resetTimer() {
                clearTimeout(t);
                t = setTimeout(triggerRefresh, ( secondsTillRefresh * 1000 ) );
            }
        };

        inactivityTime(60);
    </script>
@stop