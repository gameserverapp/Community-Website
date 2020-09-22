<div class="frame {{$type or 'simple'}} {{$class or ''}}">
    <table class="">
        <tr class="decoration-middle">
            <td class="decoration-left">
                <div class="left-repeat-top"></div>
                <div class="left-repeat-bottom"></div>
            </td>
            <td class="contentwrap">

                @isset($banner)
                    <div class=" header" @isset($banner['image']) style="background-image:url('{{$banner['image']}}')" @endisset>
                        <h1 class="title">{{$banner['title']}}</h1>

                        @if(isset($banner['category']) or isset($banner['date']))
                        <div class="meta">

                            @isset($banner['category'])
                                <div class="label label-theme category">
                                    {!! $banner['category'] !!}
                                </div>
                            @endisset

                            @isset($banner['date'])
                                <time class="label date" datetime="{{$banner['date']->toDateTimeString()}}" itemprop="datePublished">
                                    {{$banner['date']->format('j F Y')}}
                                </time>
                            @endif
                        </div>
                        @endif

                    </div>
                @endif

                @isset($title)
                    <div class="frame-title">
                        <h1 class="title">{!! $title !!}</h1>
                    </div>
                @endisset

                {!! $slot !!}

                @isset($footer)
                    <div class="frame-footer">
                        {!! $footer !!}
                    </div>
                @endif
            </td>
            <td class="decoration-right">
                <div class="right-repeat-top"></div>
                <div class="right-repeat-bottom"></div>
            </td>
        </tr>
    </table>

    <div class="decoration-top">
        <div class="top-left"></div>
        <div class="top-repeat"></div>
        <div class="top-right"></div>
    </div>
    <div class="decoration-bottom">
        <div class="bottom-left"></div>
        <div class="bottom-repeat"></div>
        <div class="bottom-right"></div>
    </div>
</div>