<?php
$id = 'modal_' . str_random();
?>

<button type="button" class="btn btn-theme {{$class ?? ''}}" data-toggle="modal" data-target="#{{$id}}" @isset($dusk) dusk="{{$dusk}}" @endif>
    <span>{!! $title !!}</span>
</button>

@push('modal_content')
    <div class="modal fade" id="{{$id}}" tabindex="-1" role="dialog" aria-labelledby="{{$id}}_label">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="{{$id}}_label">{{$confirm_modal['title']}}</h4>
                </div>
                <div class="modal-body">
                    {!! $confirm_modal['text'] !!}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>

                    @isset($confirm_modal['form_id'])
                        <button type="button" onclick="$('#{{$confirm_modal['form_id']}}').submit();" class="btn btn-warning">{!! $title !!}</button>
                    @endisset
                </div>
            </div>
        </div>
    </div>
@endpush