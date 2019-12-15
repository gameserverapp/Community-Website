<?php
use GameserverApp\Helpers\SiteHelper;
?>

<div class="container-fluid latest fulldark">

    <div class="container defaultcontent">
        <div class="row">

            <div class="col-md-6 forum">
                <h2>
                    Latest forum activity
                </h2>

                <ul>
                    @forelse( $lastForumThreads as $thread )
                        <li>
                            <article itemid="{{ Forum::route('thread.show', $thread) }}" itemscope itemtype="http://schema.org/DiscussionForumPosting">
                                <h1 class="title">
                                    <a href="{{ Forum::route('thread.show', $thread->lastPost) }}">
                                        <span itemprop="headline">{{$thread->title}}</span>
                                        <div class="badge"  itemprop="interactionStatistic" itemscope itemtype="http://schema.org/InteractionCounter">
                                            <link itemprop="interactionType" href="http://schema.org/CommentAction" />
                                            <span itemprop="userInteractionCount">{{$thread->reply_count}}</span>
                                        </div>
                                    </a>
                                </h1>
                                <h3 class="category">
                                    Posted in
                                    <a href="{{ Forum::route('category.show', $thread->category) }}">
                                        {{$thread->category->title}}
                                    </a>
                                </h3>
                                <span class="author" itemprop="author">
                                    @if(SiteHelper::featureEnabled('user_page'))
                                        By {!! $thread->lastPost->author->showLink() !!}
                                    @else
                                        By {!! $thread->lastPost->author->showName() !!}
                                    @endif
                                </span>
                                |
                                <time datetime="{{$thread->lastPost->date('updated_at')->toDateTimeString()}}" itemprop="datePublished">
                                    {{ $thread->lastPost->date('updated_at')->diffForHumans() }}
                                </time>
                            </article>
                        </li>
                    @empty
                        <li><em>No posts found</em></li>
                    @endforelse
                </ul>
                @if($lastForumThreads)
                    <a href="{{route('forum.index')}}" class="btn champ ghost dark inverted small ">
                        <span>
                            Forum &raquo;
                        </span>
                    </a>
                @endif
            </div>

            <div class="col-md-6 news">
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

        </div>
    </div>
</div>