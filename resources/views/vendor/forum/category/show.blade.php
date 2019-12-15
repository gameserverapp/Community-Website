{{-- $thread is passed as NULL to the master layout view to prevent it from showing in the breadcrumbs --}}
@extends ('forum::master', ['thread' => null])

@section ('content')
    <div id="category">

        {{--<h2>--}}
            {{--{{ $category->title }}--}}
            {{--@if ($category->description)--}}
                {{--<small>{{ $category->description }}</small>--}}
            {{--@endif--}}
        {{--</h2>--}}

        {{--<hr>--}}

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
                    <table class="table table-thread">
                        <thead>
                        <tr>
                            <th class="flag"></th>
                            <th>{{ trans('forum::general.subject') }}</th>
                            <th class="col-xs-5 text-right top-navigation">
                                {!! $category->threadsPaginated->render() !!}
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @if (!$category->threadsPaginated->isEmpty())
                            @foreach ($category->threadsPaginated->items() as $thread)
                                @include('vendor.forum.category.partials.list')
                            @endforeach
                        @else
                            <tr>
                                <td>
                                    {{ trans('forum::threads.none_found') }}
                                </td>
                                <td class="text-right" colspan="3">
                                    @can ('createThreads', $category)
                                        <a href="{{ Forum::route('thread.create', $category) }}">{{ trans('forum::threads.post_the_first') }}</a>
                                    @endcan
                                </td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                @endif

                @can ('manageThreads', $category)
                    @include ('forum::category.partials.thread-actions')
            </form>
        @endcan

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

        @can ('createCategories')
            <br>
            @include ('forum::category.partials.form-create')
        @endcan

        @can ('manageCategories')
            <form action="{{ Forum::route('category.update', $category) }}" method="POST" data-actions-form>
                {!! csrf_field() !!}
                {!! method_field('patch') !!}

                @include ('forum::category.partials.actions')
            </form>
        @endcan
    </div>
@stop
