<tr class="thread-list-item {{ $thread->trashed() ? "deleted" : "" }} {{$thread->userReadStatus}}" itemscope itemtype="http://schema.org/DiscussionForumPosting">
    <td class="flag">
        @if ($thread->locked)
            <i class="fa fa-lock" aria-hidden="true"></i>
        @endif
        @if ($thread->pinned)
            <i class="fa fa-heart" aria-hidden="true"></i>
        @endif
        @if ($thread->userReadStatus && !$thread->trashed())
            <i class="fa fa-hand-o-right" aria-hidden="true"></i>
        @endif
        @if ($thread->trashed())
            <i class="fa fa-trash" aria-hidden="true"></i>
        @endif
    </td>
    <td>
        <h3 class="title">
            <a href="{{ Forum::route('thread.show', $thread) }}" itemprop="url" class="title">
                @if ($thread->pinned)
                    <span class="important">IMPORTANT</span>
                @endif
                <span itemprop="headline">
                    {{ $thread->title }}
                </span>
                <time datetime="{{$thread->firstPost->date('created_at')->toDateTimeString()}}" itemprop="datePublished"></time>
            </a>
            @if($thread->reply_count > 0)
                <a href="{{Forum::route('thread.show', $thread->lastPost)}}" class="last-post">
                    [last post]
                </a>
            @endif
        </h3>
        <a href="{{ Forum::route('thread.show', $thread) }}">
            <p class="author">
                <span class="created">Created by</span>
                <span itemscope itemtype="http://schema.org/Person" itemprop="author">
                    <span itemprop="name">
                        {{ $thread->firstPost->author->name() }}
                    </span>
                </span>
            </p>
        </a>
    </td>
    @if ($thread->trashed())
        <td>&nbsp;</td>
    @else
        <td class="text-right meta">
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
                        <link itemprop="interactionType" href="http://schema.org/CommentAction" />
                        <span itemprop="userInteractionCount">{{ $thread->reply_count }}</span>
                    </span>
                </a>
            </article>
        </td>
    @endif
    {{--@can ('manageThreads', $category)--}}
    {{--<td class="text-right">--}}
    {{--<input type="checkbox" name="items[]" value="{{ $thread->id }}">--}}
    {{--</td>--}}
    {{--@endcan--}}
</tr>