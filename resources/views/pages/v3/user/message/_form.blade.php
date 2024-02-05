<?php
if(isset($message)) {
    $title = 'Send reply to';
    $routeId = $message->sender->id;
    $btnText = 'Send reply';
} else {
    $title = 'New message to';
    $routeId = $receiver->id;
    $btnText = 'Send message';
}

if(!empty( $receiver->name )) {
    $title .= ' ' . $receiver->showLink();
} elseif(isset($message)) {
    if(in_array($message->receiver->id, auth()->user()->allUserIds())) {
        $title .= ' ' . $message->sender->showLink();
    } else {
        $title .= ' ' . $message->receiver->showLink();
    }
} else {
    $title .= ' player';
}
?>

@component('partials.v3.frame', ['title' => $title, 'type' => 'basic'])
    <form method="post" action="{{route('message.send', $routeId)}}">
        {{csrf_field()}}

        @if(isset( $message ) )
            <input type="hidden" name="subject" value="{{$message->subject}}">
        @else
            <div class="form-group">
                <label>Subject</label>
                <input type="text" class="form-control" name="subject" value="{{old('subject')}}">
            </div>
        @endif

        <div class="form-group">
            <label>Message</label>
            <textarea type="text" class="form-control simplemde" name="content">{{old('content')}}</textarea>
        </div>

        <br>

        @include('partials.v3.button', [
            'element' => 'button',
            'type' => 'submit',
            'title' => $btnText,
            'class' => 'center btn-theme-rock'
        ])

    </form>
@endcomponent