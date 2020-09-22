<div class="news">
    <h2>
        Latest news & updates
    </h2>

    <ul>
        @forelse($lastNewsPosts as $news )
            <li>
                <article itemscope itemtype="http://schema.org/Article">
                    <h1 class="title">
                        @if($news->hasType())
                            {!! $news->presentType() !!}
                        @endif
                        <a href="{{ route('news.show', [$news->id, $news->slug() ])}}"  itemprop="headline url">
                            {!! $news->title() !!}
                        </a>
                    </h1>
                    <p class="summary">
                        <a href="{{ route('news.show', [$news->id, $news->slug() ])}}">
                            <time itemprop="datePublished" datetime="{{$news->date('published_at')->toDateTimeString()}}">
                                {{ $news->date('published_at')->format('d F Y') }}
                            </time> -
                            <span itemprop="description">
                                            {!! $news->summary() !!}
                                        </span>
                        </a>
                        </span>
                </article>
            </li>
        @empty

        @endforelse
    </ul>
    <a href="{{route('news.index')}}" class="btn champ ghost dark inverted small ">
                    <span>
                        All news &raquo;
                    </span>
    </a>
</div>