<article class="article-block" itemscope itemtype="http://schema.org/Article">
    <a href="{{route('news.show', ['id' => $post->id, 'slug' => $post->slug()])}}" itemprop="url">

        @if($post->hasImage())
            <div class="article-block__image">
                <img src="{{$post->image()}}">
            </div>
        @endif

        <h1 class="article-block__title" itemprop="headline">
            {!! $post->title() !!}
        </h1>

        <time class="article-block__date" datetime="{{$post->date('published_at')->toDateTimeString()}}" itemprop="datePublished">
            {{$post->date('published_at')->format('j F Y')}}

            @if($post->hasType())
                &nbsp;&nbsp;
                {!! $post->presentType() !!}
            @endif
        </time>

        <div class="article-block__summary">
            <span class="markdown-content" itemprop="description">
                {!! Markdown::convertToHtml($post->summary()) !!}
            </span>
            <span class="readmore">
                Continue reading &raquo;
            </span>
        </div>
    </a>
</article>