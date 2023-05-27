<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">

<link rel="shortcut icon" type="image/png" href="{{GameserverApp\Helpers\SiteHelper::favicon()}}"/>
<link rel="apple-touch-icon" href="/img/shortcut-icon.png">
<meta name="apple-mobile-web-app-title" content="{{GameserverApp\Helpers\SiteHelper::name()}}">
<meta property="og:image" content="{{GameserverApp\Helpers\SiteHelper::embedImage()}}">

<meta name="description" content="{{$page['description'] or GameserverApp\Helpers\SiteHelper::seoDescription()}}">

<script type="application/ld+json">
{
  "@context": "http://schema.org",
  "@type": "WebSite",
  "url": "{{url('/')}}",
  "potentialAction": {
    "@type": "SearchAction",
    "target": "{{url('/')}}/{{GameserverApp\Helpers\RouteHelper::inspector()}}?search={search_term_string}",
    "query-input": "required name=search_term_string"
  }
}
</script>

<title>{{$page['title'] or 'Community website'}} - {{GameserverApp\Helpers\SiteHelper::name()}}</title>

<link href='{{GameserverApp\Helpers\SiteHelper::googleFontsUrl()}}' rel='stylesheet' type='text/css'>

<link rel="stylesheet" type="text/css" href="{{ mix('css/style.css') }}">

@if(!is_null(GameserverApp\Helpers\SiteHelper::customCssUrl()) and !empty(GameserverApp\Helpers\SiteHelper::customCssUrl()) )
    <link rel="stylesheet" type="text/css" href="{{ GameserverApp\Helpers\SiteHelper::customCssUrl() }}">
@endif

<style rel="stylesheet" type="text/css">
    body *:not(.fa):not(.fc-icon) {
        font-family: "{{ GameserverApp\Helpers\SiteHelper::googleFont() }}" !important;
    }

    :root {
        @if(is_object(GameserverApp\Helpers\SiteHelper::themeColors()))
            @foreach(GameserverApp\Helpers\SiteHelper::themeColors() as $key => $color)
                --{{$key}}: {{$color}};
            @endforeach
        @endif
    }

    @if(!is_null(GameserverApp\Helpers\SiteHelper::logo()) and !empty(GameserverApp\Helpers\SiteHelper::logo()) )
        .navbar-brand {
            padding:5px !important;
            height:52px;
        }

        .navbar-brand h1 {
            background-image:url({{GameserverApp\Helpers\SiteHelper::logo()}});
            background-repeat:no-repeat;
            background-size: contain;
            width: 200px;
            height:100%;
            max-height:52px;
            text-indent: -99999px;
        }
    @endif


    @if(!is_null(GameserverApp\Helpers\SiteHelper::customCss()) and !empty(GameserverApp\Helpers\SiteHelper::customCss()) )
        {!! GameserverApp\Helpers\SiteHelper::customCss() !!}
    @endif
</style>

<?php
$gaIds = GameserverApp\Helpers\SiteHelper::googleAnalyticsId();
?>

@if(!is_null($gaIds))

    <?php
    if(!is_array($gaIds)) {
        $firstId = $gaIds;
    } else {
        $firstId = $gaIds[0];
    }
    ?>


    <meta name="testgsa" content="{{$firstId}}">

    @if(substr($firstId, 0, 2) == 'G-')

        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id={{$firstId}}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', '{{$firstId}}');
        </script>
    @else
        <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

            ga('create', '{{$firstId}}', 'auto');

            ga('send', 'pageview');

        </script>
    @endif


@endif