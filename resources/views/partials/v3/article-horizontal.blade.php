<article class="article-horizontal" itemscope itemtype="http://schema.org/Article">
    <div class="article-wrapper">
        <a href="{{$route}}" class="bg-image" style="background-image:url('{{$image}}')"></a>

        <div class="content-wrapper">
            <div class="content">
                <a href="{{$route}}" itemprop="url">
                    <h1 class="title">{{$title}}</h1>
                    <div class="meta">
                        @isset($category)
                            <div class="label label-theme category">
                                {!! $category !!}
                            </div>
                        @endisset
                        <time class="date" datetime="{{$date->toDateTimeString()}}" itemprop="datePublished">
                            {{$date->format('j F Y')}}
                        </time>
                    </div>
                    <div class="summary">
                        {{$summary}}
                    </div>
                </a>
                @include('partials.v3.button', [
                    'route' => $route,
                    'title' => translate('read_more', 'Read more')
                ])
            </div>
        </div>
    </div>

</article>