@extends ('forum::master', ['breadcrumb_other' => trans('forum::threads.new_thread')])

@section ('content')
    <div class="row">
        <div class="col-md-8 center-block">
            <form method="POST" action="{{ Forum::route('thread.store', $category) }}">

                @component('partials.v3.frame', ['title' => trans('forum::threads.new_thread') . ' - ' . $category->title])

                    {!! csrf_field() !!}
                    {!! method_field('post') !!}

                    <div class="form-group">
                        <label for="title">{{ trans('forum::general.title') }}</label>
                        <input type="text" name="title" value="{{ old('title') }}" class="form-control">
                    </div>

                    <div class="form-group">
                        <textarea name="content" rows="13" class="form-control simplemde">{{ old('content') }}</textarea>
                    </div>

                @endcomponent

                <div class="text-center">
                    <button type="submit" class="btn btn-theme btn-theme-rock">
                        <span>{{ trans('forum::general.create') }}</span>
                    </button>
                </div>
            </form>

        </div>
    </div>
@endsection
