<!-- Button trigger modal -->
<button type="button" class="btn btn-theme small" data-toggle="modal" data-target="#threadActions">
    <span>
        Actions
    </span>
</button>

@push('modal_content')
<form action="{{ Forum::route('thread.update', $thread) }}" method="POST" data-actions-form>
    {!! csrf_field() !!}
    {!! method_field('patch') !!}
    <div class="modal fade" id="threadActions" tabindex="-1" role="dialog" aria-labelledby="threadActionsLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="threadActionsLabel">{{ trans('forum::threads.actions') }}</h4>
                </div>
                <div class="modal-body category-options" data-actions>
                    <div class="form-group">
                        <label for="action">{{ trans_choice('forum::general.actions', 1) }}</label>
                        <select name="action" id="action" class="form-control">
                            @can ('deleteThreads', $category)
                                @if ($thread->trashed())
                                    <option value="restore" data-confirm="true">{{ trans('forum::general.restore') }}</option>
                                @else
                                    <option value="delete" data-confirm="true" data-method="delete">{{ trans('forum::general.delete') }}</option>
                                @endif
                                <option value="permadelete" data-confirm="true" data-method="delete">{{ trans('forum::general.perma_delete') }}</option>
                            @endcan

                            @if (!$thread->trashed())
                                @can ('moveThreadsFrom', $category)
                                    <option value="move">{{ trans('forum::general.move') }}</option>
                                @endcan
                                @can ('lockThreads', $category)
                                    @if ($thread->locked)
                                        <option value="unlock">{{ trans('forum::threads.unlock') }}</option>
                                    @else
                                        <option value="lock">{{ trans('forum::threads.lock') }}</option>
                                    @endif
                                @endcan
                                @can ('pinThreads', $category)
                                    @if ($thread->pinned)
                                        <option value="unpin">{{ trans('forum::threads.unpin') }}</option>
                                    @else
                                        <option value="pin">{{ trans('forum::threads.pin') }}</option>
                                    @endif
                                @endcan
                                @can ('rename', $thread)
                                    <option value="rename">{{ trans('forum::general.rename') }}</option>
                                @endcan
                            @endif
                        </select>
                    </div>
                    <div class="form-group hidden" data-depends="move">
                        <label for="category-id">{{ trans_choice('forum::categories.category', 1) }}</label>
                        <select name="category_id" id="category-id" class="form-control">
                            @include ('forum::category.partials.options', ['hide' => $thread->category])
                        </select>
                    </div>
                    <div class="form-group hidden" data-depends="rename">
                        <label for="new-title">{{ trans('forum::general.title') }}</label>
                        <input type="text" name="title" value="{{ $thread->title }}" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-default pull-right">{{ trans('forum::general.proceed') }}</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endpush
