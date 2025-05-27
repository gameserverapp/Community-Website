<!doctype html>
<html lang="en">
    <head>
        @include('layouts.v3._meta')
    </head>

    <?php
    $hasAlert = GameserverApp\Helpers\SiteHelper::navAlert();
    ?>

    <body class="v3 {{$page['class'] ?? ''}} @if($hasAlert) has-alert @endif {{GameserverApp\Helpers\SiteHelper::theme()}}" {{$microdata['body'] ?? ''}}>
        <div style="background-image:url('{{$page['image'] ?? GameserverApp\Helpers\SiteHelper::background()}}')" class="full-bg"></div>

        @if($hasAlert)
            <div class="nav-alert">
                {{$hasAlert}}
            </div>
        @endif

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