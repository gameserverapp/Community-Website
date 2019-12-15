<ol class="breadcrumb" itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
    <li><a href="{{ url(config('forum.routing.root') . config('forum.routing.prefix')) }}">Forum</a></li>
    @if (isset($category) && $category)
        @include ('forum::partials.breadcrumb-categories', ['category' => $category])
    @endif
    @if (isset($thread) && $thread)
        <li itemprop="child" itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
            <a itemprop="url" title="{{ $thread->title }}" href="{{ Forum::route('thread.show', $thread) }}">{{ $thread->title }}</a>
        </li>
    @endif
    @if (isset($breadcrumb_other) && $breadcrumb_other)
        <li itemprop="child" itemscope itemtype="http://data-vocabulary.org/Breadcrumb">{!! $breadcrumb_other !!}</li>
    @endif
</ol>
