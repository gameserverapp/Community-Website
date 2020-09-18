{{-- $thread is passed as NULL to the master layout view to prevent it from showing in the breadcrumbs --}}
@extends ('forum::master', ['thread' => null])

@section ('content')

    <div class="row">
        <div class="col-md-3 title-buttons">
            @can('createCategories')
                @include ('forum::category.partials.form-create')
            @endcan

            @can('manageCategories')
                @include ('forum::category.partials.actions')
            @endcan
        </div>
        <div class="col-md-6 text-center">
            <h2>{{ $category->title }}</h2>

            @if ($category->description)
                <div class="category-description">{{ $category->description }}</div>
            @endif
        </div>
        <div class="col-md-3 title-buttons text-right">
            @if (isset( $category ) and $category->threadsEnabled)
                @can ('createThreads', $category)
                    <a class="btn btn-theme btn-theme-gem" href="{{ Forum::route('thread.create', $category) }}">
                        <span>{{ trans('forum::threads.new_thread') }}</span>
                    </a>
                @endcan
            @endif
        </div>
    </div>

    <div id="category">

        @if (!$category->children()->isEmpty())
            @foreach ($category->children() as $subcategory)
                @include('forum::custom.category', ['category' => $subcategory])
            @endforeach
        @endif

        @can ('manageThreads', $category)
            <form action="{{ Forum::route('bulk.thread.update') }}" method="POST" data-actions-form>
                {!! csrf_field() !!}
                {!! method_field('delete') !!}
        @endcan

        @if ($category->threadsEnabled)
            @component('partials.v3.frame', ['type' => 'basic', 'class' => 'forum-thread-table'])
                <div class="frame-title">
                    <div class="row">
                        <div class="col-xs-7">
                            <div class="flag"> </div>
                            {{ trans('forum::general.subject') }}
                        </div>
                        <div class="col-xs-5 text-right">
                            <div class="paginate tiny">
                                {!! $category->threadsPaginated->render() !!}
                            </div>
                        </div>
                    </div>
                </div>

                <article class="table-thread">
                    @if (!$category->threadsPaginated->isEmpty())
                        @foreach ($category->threadsPaginated->items() as $thread)
                            @include('vendor.forum.category.partials.list')
                        @endforeach
                    @else
                        <div class="row">
                            <div class="col-md-8">
                                <p></p>
                                <p>
                                    {{ trans('forum::threads.none_found') }}
                                </p>
                            </div>
                            <div class="col-md-4 text-right">
                                <p>

                                </p>
                                @can ('createThreads', $category)
                                    <a href="{{ Forum::route('thread.create', $category) }}">{{ trans('forum::threads.post_the_first') }}</a>
                                @endcan
                            </div>
                        </div>
                    @endif
                </article>
            @endcomponent
        @endif

{{--        @can('manageThreads', $category)--}}
{{--            @include ('vendor.forum.category.partials.thread-actions')--}}
{{--        @endcan--}}

        <div class="row">
            <div class="col-xs-8 center-block text-center">
                <div class="paginate">
                    {!! $category->threadsPaginated->render() !!}
                </div>
            </div>
        </div>

        @if ($category->threadsEnabled)
            @can ('markNewThreadsAsRead')
                <hr>
                <div class="text-center">
                    <form action="{{ Forum::route('mark-new') }}" method="POST" data-confirm>
                        {!! csrf_field() !!}
                        {!! method_field('patch') !!}
                        <input type="hidden" name="category_id" value="{{ $category->id }}">
                        <button class="btn btn-default btn-small">{{ trans('forum::categories.mark_read') }}</button>
                    </form>
                </div>
            @endcan
        @endif
    </div>
@stop
