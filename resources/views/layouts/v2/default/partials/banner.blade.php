<div class="container-fluid banner {{ $banner['size'] ?? 'small' }}  {{ $banner['class'] ?? '' }} {{ ( isset( $banner['navigation'] ) ) ? 'navigation' : '' }}">

    @if( isset( $banner['background'] ) )

        @if(isset( $banner['background']['img'] ))

            <div class="background">
                <img src="{{$banner['background']['img']}}">
            </div>

        @elseif(isset( $banner['background']['tribe'] ))

            <div class="background mozaiek">
                {!! $banner['background']['tribe'] !!}
            </div>

        @endif
    @else
        <div class="background fallback">
            <span style="background-image:url({{\GameserverApp\Helpers\SiteHelper::background()}})"></span>
        </div>
    @endif

    <div class="container banner_content_wrap {{ ( isset( $banner['vertical-align'] ) and $banner['vertical-align'] ) ? 'vertical_align' : '' }}">
        <div class="row banner_content">

            @if( isset( $banner['text-only'] ) and $banner['text-only'] )
                <div class="col-md-8 text-only center-block">
                    <h1>@yield('banner_content')</h1>
                </div>
            @elseif( isset( $banner['content'] ) and $banner['content'] )
                {!! $banner['content'] !!}
            @else
                @yield('banner_content')
            @endif

        </div>
    </div>

    @if( isset( $banner['navigation'] ) )

        <div class="container navigation">
            <div id="select-nav"></div>
            <div class="row">
                @include($banner['navigation'])
            </div>
        </div>

    @elseif( isset( $banner['down-button'] )  and $banner['down-button'] )

        <div class="row scrolldown {{ ( isset( $banner['animated'] ) and $banner['animated'] ) ? 'animated' : '' }}">
            <div class="col-md-5 center-block text-center">
                <a href="#" id="scrolldown">
                    <i class="fa fa-angle-down"></i>
                </a>
            </div>
        </div>

    @endif
</div>