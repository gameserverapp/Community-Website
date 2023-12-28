@extends ('forum::master', ['breadcrumb_other' => trans('forum::posts.edit')])

@section ('content')

    <div class="row">
        <div class="col-md-8 center-block">

            <form method="POST" action="{{ Forum::route('post.update', $post) }}">
                {!! csrf_field() !!}
                {!! method_field('patch') !!}

                @component('partials.v3.frame', ['title' => trans('forum::posts.edit') . ' - ' . $thread->title])
                    <div class="form-group">
                        <textarea name="content" rows="13" class="form-control simplemde">{{ !is_null(old('content')) ? old('content') : $post->content }}</textarea>
                    </div>
                @endcomponent

                <div class="text-center">
                    <button type="submit" class="btn btn-theme btn-theme-rock">
                        <span>Update post</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
