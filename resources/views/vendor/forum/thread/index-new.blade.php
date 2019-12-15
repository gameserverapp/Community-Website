@extends ('forum::master', ['breadcrumb_other' => trans('forum::threads.new_updated')])

@section ('content')
    <h2>{{ trans('forum::threads.new_updated') }}</h2>

    @if (!$threads->isEmpty())
        <table class="table table-index">
            <thead>
                <tr>
                    <th>Title</th>
                    <th class="col-md-2">{{ trans('forum::general.replies') }}</th>
                    <th class="col-md-2 text-right">{{ trans('forum::posts.last') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($threads as $thread)
                    <tr itemscope itemtype="http://schema.org/Discussion">
                        <td>
                            <span class="pull-right">
                                @if ($thread->locked)
                                    <span class="label label-danger">{{ trans('forum::threads.locked') }}</span>
                                @endif
                                @if ($thread->pinned)
                                    <span class="label label-info">{{ trans('forum::threads.pinned') }}</span>
                                @endif
                                @if ($thread->userReadStatus)
                                    <span class="label label-primary">{{ trans($thread->userReadStatus) }}</span>
                                @endif
                            </span>
                            <p class="lead">
                                <a href="{{ Forum::route('thread.show', $thread) }}" itemprop="headline url">{{ $thread->title }}</a>
                            </p>
                            <p>
                                <span itemscope itemtype="http://schema.org/Person" itemprop="author">
                                    <span itemprop="name">
                                        {{ $thread->authorName }}
                                    </span>
                                </span>
                                <span class="text-muted">(<em><a href="{{ Forum::route('category.show', $thread->category) }}">{{ $thread->category->title }}</a></em>, {{ $thread->posted }})</span>
                            </p>
                        </td>
                        <td itemprop="interactionStatistic" itemscope itemtype="http://schema.org/InteractionCounter">
                            <link itemprop="interactionType" href="http://schema.org/CommentAction" />
                            <span itemprop="userInteractionCount">{{ $thread->replyCount }}</span>
                        </td>
                        <td class="text-right">
                            <span itemscope itemtype="http://schema.org/Person" itemprop="Contributer">
                                    <span itemprop="name">
                                        {{ $thread->lastPost->authorName }}
                                    </span>
                            </span>
                            <p class="text-muted">(<time datetime="{{ $thread->lastPost->posted->toDateTimeString() }}" itemprop="dateCreated">{{ $thread->lastPost->posted }}</time>)</p>
                            <a href="{{ Forum::route('thread.show', $thread->lastPost) }}" class="btn btn-primary btn-xs">{{ trans('forum::posts.view') }} &raquo;</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @can ('markNewThreadsAsRead')
            <div class="text-center">
                <form action="{{ Forum::route('mark-new') }}" method="POST" data-confirm>
                    {!! csrf_field() !!}
                    {!! method_field('patch') !!}
                    <button class="btn btn-primary btn-small">{{ trans('forum::general.mark_read') }}</button>
                </form>
            </div>
        @endcan
    @else
        <p class="text-center">
            {{ trans('forum::threads.none_found') }}
        </p>
    @endif
@stop
