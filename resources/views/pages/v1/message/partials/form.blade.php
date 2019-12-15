@include('partials.frame.simple-top')
<div class="form panel panel-default @if( isset( $message ) ) reply @endif">
    <div class="panel-heading">
        <strong>
            @if( isset( $message ) )
                Send reply to
            @else
                New message to
            @endif

            @if( !empty( $receiver->name ) )
                {!! $receiver->showName() !!}
            @elseif( isset( $message ) )
                @if($message->receiver->id == auth()->id())
                    {!! $message->sender->showName() !!}
                @else
                    {!! $message->receiver->showName() !!}
                @endif
            @else
                player
            @endif
        </strong>
    </div>

    @if( isset( $message ) )
        {!! Form::open(['route'=>['message.send', $message->sender->id]]) !!}
    @else
        {!! Form::open(['route'=>['message.send', $receiver->id]]) !!}
    @endif

    <div class="panel-body form" role="form">
        @if( isset( $message ) )
            {!! Form::hidden('subject', $message->subject, array('class' => 'form-control')) !!}
        @else
            <div class="form-group">
                {!! Form::label('subject', 'Subject', ['for' => 'subject' ]) !!}
                {!! Form::text('subject', old('subject'), array('class' => 'form-control')) !!}
            </div>
        @endif

        <div class="form-group">
            @if( isset( $message ) )
                {!! Form::label('content', 'Message', ['for' => 'message' ]) !!}
            @else
                {!! Form::label('content', 'Message', ['for' => 'content' ]) !!}
            @endif

            {!! Form::textarea('content', old('content'), array('class' => 'form-control simplemde')) !!}
        </div>

    </div>

    <div class="panel-footer">
        @if( !isset( $message ) )
            {!! link_to(route('message.inbox'), 'Cancel', array('class' => 'btn btn-default')) !!}
            {!! Form::submit('Send', array('class' => 'btn champ small right')) !!}
        @else
            {!! Form::submit('Reply', array('class' => 'btn champ small right')) !!}
        @endif
    </div>

    {!! Form::close() !!}

</div>
@include('partials.frame.simple-bottom')


<div class="alert alert-info">
    <i class="fa fa-question-circle" aria-hidden="true"></i>
    <span class="indent">
        Abuse will result in a ban from the <u>entire</u> GameserverApp.com platform.
    </span>
</div>