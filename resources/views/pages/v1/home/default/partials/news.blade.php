<div class="container-fluid latest">

    <div class="container defaultcontent">
        <div class="row">

            <div class="col-md-12 news">
                <h2>
                    Latest news & updates
                </h2>

                <div class="row">
                    @forelse($lastNewsPosts->slice(0,3) as $news )
                        <div class="col-md-4">
                            <ul>
                                <li>
                                    <article itemscope itemtype="http://schema.org/Article">
                                        <h1 class="title">
                                            @if($news->hasType())
                                                {!! $news->presentType() !!}
                                            @endif
                                            <a href="{{ route('news.show', [$news->id, $news->slug() ])}}"
                                               itemprop="headline url">
                                                {!! $news->title() !!}
                                            </a>
                                        </h1>
                                        <p class="summary">
                                            <a href="{{ route('news.show', [$news->id, $news->slug ])}}">
                                                <time itemprop="datePublished"
                                                      datetime="{{$news->date('published_at')->toDateTimeString()}}">
                                                    {{ $news->date('published_at')->diffForHumans() }}
                                                </time>
                                                -
                                                <span itemprop="description">
                                                    {{ $news->summary() }}
                                                </span>
                                            </a>
                                        </p>
                                    </article>

                                </li>
                            </ul>
                        </div>
                    @empty
                        <div class="col-md-4">
                            <em>No news found</em>
                        </div>
                    @endforelse
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12 text-center">
                        <a href="{{route('news.index')}}" class="btn champ ghost dark inverted small ">
                            <span>
                                All news &raquo;
                            </span>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>