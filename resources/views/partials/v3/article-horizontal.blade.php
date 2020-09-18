<article class="article-horizontal {{$class or ''}}" itemscope itemtype="http://schema.org/Article">
    <div class="article-wrapper">
        <a href="{{$route}}" class="bg-image" style="background-image:url('{{$image}}')"></a>

        @if(isset($category) and is_array($category))
            <div class="category-wrapper">
                @foreach($category as $label)
                    <div class="label label-theme category">
                        {!! $label !!}
                    </div>
                @endforeach
            </div>
        @endif

        <div class="content-wrapper">
            <div class="content">
                <a href="{{$route}}" itemprop="url">
                    <h1 class="title">{{$title}}</h1>
                    <div class="meta">

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