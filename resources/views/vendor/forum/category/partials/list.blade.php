<article class="row thread-list-item {{ $thread->trashed() ? "deleted" : "" }} {{$thread->userReadStatus}}" itemscope
     itemtype="http://schema.org/DiscussionForumPosting">
    <div class="col-xs-7">
        <div class="title-flag">

            <div class="flag">
                @if ($thread->locked)
                    <i class="fa fa-lock" aria-hidden="true"></i>
                @endif
                @if ($thread->pinned)
                    <i class="fa fa-thumb-tack" aria-hidden="true"></i>
                @endif
                @if ($thread->trashed())
                    <i class="fa fa-trash" aria-hidden="true"></i>
                @endif
            </div>
            <div class="title">
                <h1>
                    <a href="{{ Forum::route('thread.show', $thread) }}" itemprop="url">
                        <span itemprop="headline">
                            {{ $thread->title }}
                        </span>
                        <time datetime="{{$thread->firstPost->date('created_at')->toDateTimeString()}}"
                              itemprop="datePublished"></time>
                    </a>
                    @if ($thread->userReadStatus && !$thread->trashed())
                        <span class="label label-theme">Unread</span>
                    @endif
                    @if($thread->reply_count > 0)
                        <a href="{{Forum::route('thread.show', $thread->lastPost)}}" class="last-post">
                            [last post]
                        </a>
                    @endif
                </h1>
                <div class="author">
                    <span class="created">Created by</span>
                    <a href="{{$thread->firstPost->author->showRoute()}}" itemscope itemtype="http://schema.org/Person" itemprop="author">
                        <span itemprop="name">
                            {{ $thread->firstPost->author->name() }}
                        </span>
                    </a>
                </div>
            </div>
        </div>

    </div>
    @if ($thread->trashed())
        <div class="col-xs-5">&nbsp;</div>
    @else
        <div class="col-xs-5 text-right meta">
            <article class="last-post">
                <a href="{{Forum::route('thread.show', $thread->lastPost)}}">
                    <span class="posted">{{ $thread->lastPost->date('created_at')->diffForHumans() }} by</span>
                    <span itemscope itemtype="http://schema.org/Person">
                        <span itemprop="name">
                            {{ $thread->lastPost->author->name() }}
                        </span>
                    </span>
                </a>
            </article>
            <article class="replies">
                <a href="{{Forum::route('thread.show', $thread->lastPost)}}">
                    <i class="fa fa-comments-o" aria-hidden="true"></i>
                    <span itemprop="interactionStatistic" itemscope itemtype="http://schema.org/InteractionCounter">
                        <link itemprop="interactionType" href="http://schema.org/CommentAction"/>
                        <span itemprop="userInteractionCount">{{ $thread->reply_count }}</span>
                    </span>
                </a>
            </article>
        </div>
    @endif
    {{--@can ('manageThreads', $category)--}}
    {{--<td class="text-right">--}}
    {{--<input type="checkbox" name="items[]" value="{{ $thread->id }}">--}}
    {{--</td>--}}
    {{--@endcan--}}
</article>