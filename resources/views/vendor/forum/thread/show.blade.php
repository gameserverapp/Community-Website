@extends ('forum::master')

@section ('content')
    <div id="thread" class="thread-show" itemscope itemtype="http://schema.org/DiscussionForumPosting">

        @if(auth()->check())

            <div class="follow">

                @if (isset( $category ) and $category->threadsEnabled)
                    @can ('createThreads', $category)
                        <a class="btn champ  small" href="{{ Forum::route('thread.create', $category) }}">
                            {{ trans('forum::threads.new_thread') }}
                        </a>
                        &nbsp; &nbsp;
                    @endcan
                @endif

                @if(!auth()->user()->subscribedToThread($thread))
                    <a href="{{route('user.forum.subscribe',[$thread->id])}}" class="btn champ small">Subscribe</a>
                @else
                    <a href="{{route('user.forum.unsubscribe',[$thread->id])}}" class="btn champ inverted dark small">Unsubscribe</a>
                @endif
            </div>
        @endif

        <h2 class="title">
            @if ($thread->trashed())
                <span class="label label-danger">{{ trans('forum::general.deleted') }}</span>
            @endif
            @if ($thread->locked)
                <span class="label label-warning">{{ trans('forum::threads.locked') }}</span>
            @endif
            @if ($thread->pinned)
                <span class="label label-info">{{ trans('forum::threads.pinned') }}</span>
            @endif
            <span itemprop="headline">{{ $thread->title }}</span>

            <time datetime="{{$thread->firstPost->date('created_at')->toDateTimeString()}}" itemprop="datePublished"></time>

        </h2>

        <table class="table forum-thread-single {{ $thread->trashed() ? 'deleted' : '' }}">
            <tbody>
                @foreach ($thread->postsPaginated as $post)
                    @include ('forum::post.partials.list', compact('post'))
                @endforeach
            </tbody>
        </table>

        <div class="paginate">
            {!! $thread->postsPaginated->render() !!}
        </div>

        @can ('reply', $thread)
            <div class="row">
                <div class="col-md-10 center-block">
                    <br><br>
                    <h3>{{ trans('forum::general.reply') }}</h3>
                    <div id="reply">
                        <form method="POST" action="{{ Forum::route('post.store', $thread) }}">
                            {!! csrf_field() !!}

                            <div class="form-group">
                                <textarea name="content" class="form-control simplemde">{{ old('content') }}</textarea>
                            </div>

                            <button type="submit" class="btn champ small pull-right">{{ trans('forum::general.reply') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        @endcan

        @can ('manageThreads', $category)
            <br><br>
            <form action="{{ Forum::route('thread.update', $thread) }}" method="POST" data-actions-form>
                {!! csrf_field() !!}
                {!! method_field('patch') !!}

                @include ('forum::thread.partials.actions')
            </form>
        @endcan
    </div>
@stop

@section ('footer')
    <script>
    $('tr input[type=checkbox]').change(function () {
        var postRow = $(this).closest('tr').prev('tr');
        $(this).is(':checked') ? postRow.addClass('active') : postRow.removeClass('active');
    });
    </script>
@stop
