<!doctype html>
<html lang="en">
    <head>
        @include('layouts.v3._meta')
    </head>

    <body class="v3 {{$page['class'] or ''}} {{GameserverApp\Helpers\SiteHelper::theme()}}" {{$microdata['body'] or ''}}>
        <div style="background-image:url('{{$page['image'] or GameserverApp\Helpers\SiteHelper::background()}}')" class="full-bg"></div>

        @include('layouts.v3._flash')

        @include('layouts.v3._nav')

        @if(isset($microdata['content']))
            <span {{$microdata['content']}}>
        @endif

            @yield('layout_content')

        @if(isset($microdata['content']))
            </span>
        @endif

        @include('layouts.v3._footer')

        @stack('modal_content')

        @yield('footer_scripts')
    </body>
</html>