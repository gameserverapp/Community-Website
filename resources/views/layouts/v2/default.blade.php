<!doctype html>
<html lang="en">
    <head>
        @include('layouts.v2.default.meta')
    </head>

    <body class="v2 {{$page['class'] ?? ''}} {{GameserverApp\Helpers\SiteHelper::theme()}}" {{$microdata['body'] ?? ''}}>

        @include('layouts.v2.default.flash')

        @include('layouts.v2.default.nav')

        @if(isset($microdata['content']))
            <span {{$microdata['content']}}>
        @endif

            @yield('layout_content')

        @if(isset($microdata['content']))
            </span>
        @endif

        @include('layouts.v2.default.footer')

        @yield('footer_scripts')
    </body>
</html>