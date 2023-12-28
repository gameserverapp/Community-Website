@extends ('forum::master')

@section ('content')
    <div id="thread" class="thread-show" itemscope itemtype="http://schema.org/DiscussionForumPosting">


        <div class="row">
            <div class="col-md-3 title-buttons">
                @can ('manageThreads', $category)
                    @include ('forum::thread.partials.actions')
                @endcan
            </div>
            <div class="col-md-6 text-center">
                <h2 class="title">
                    <span itemprop="headline">{{ $thread->title }}</span>

                    <time datetime="{{$thread->firstPost->date('created_at')->toDateTimeString()}}" itemprop="datePublished"></time>
                </h2>

                <div class="labels">
                    @if ($thread->trashed())
                        <span class="label label-danger">{{ trans('forum::general.deleted') }}</span>
                    @endif
                    @if ($thread->locked)
                        <span class="label label-theme">{{ trans('forum::threads.locked') }}</span>
                    @endif
                    @if ($thread->pinned)
                        <span class="label label-theme">{{ trans('forum::threads.pinned') }}</span>
                    @endif
                </div>
            </div>
            <div class="col-md-3 title-buttons text-right">
                @if(auth()->check())

                    <div class="follow">

                        @if (isset( $category ) and $category->threadsEnabled)
                            @can ('createThreads', $category)
                                <a class="btn btn-theme btn-theme-gem small" href="{{ Forum::route('thread.create', $category) }}">
                                    <span>{{ trans('forum::threads.new_thread') }}</span>
                                </a>
                                &nbsp; &nbsp;
                            @endcan
                        @endif

                        @if(!auth()->user()->subscribedToThread($thread))
                            <a href="{{route('user.forum.subscribe',[$thread->id])}}" class="btn btn-theme small"><span>Subscribe</span></a>
                        @else
                            <a href="{{route('user.forum.unsubscribe',[$thread->id])}}" class="btn btn-theme small"><span>Unsubscribe</span></a>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        <div class="forum-thread-single {{ $thread->trashed() ? 'deleted' : '' }}">
            @foreach ($thread->postsPaginated as $post)
                <div class="row">
                    <div class="col-md-12">
                        @include ('forum::post.partials.list', compact('post'))
                    </div>
                </div>
            @endforeach
        </div>

        <div class="paginate">
            {!! $thread->postsPaginated->render() !!}
        </div>

        @can ('reply', $thread)
            <div class="row">
                <div class="col-md-8 center-block">

                    <form method="POST" action="{{ Forum::route('post.store', $thread) }}">
                        {!! csrf_field() !!}
                        @component('partials.v3.frame', ['type' => 'basic', 'title' => trans('forum::general.reply')])
                            <div id="reply">
                                <div class="form-group">
                                    <textarea name="content" class="form-control simplemde">{{ old('content') }}</textarea>
                                </div>
                            </div>
                        @endcomponent
                        <button type="submit" class="btn btn-theme btn-theme-rock center">
                            <span>{{ trans('forum::general.reply') }}</span>
                        </button>
                    </form>
                </div>
            </div>
        @endcan
    </div>
@endsection

@section ('footer')
    <script>
    $('tr input[type=checkbox]').change(function () {
        var postRow = $(this).closest('tr').prev('tr');
        $(this).is(':checked') ? postRow.addClass('active') : postRow.removeClass('active');
    });
    </script>
@endsection
