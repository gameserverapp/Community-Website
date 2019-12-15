<div class="row">
    <div class="col-md-10 center-block text-right">
        @include('pages.v1.message.partials.newbutton')
    </div>
</div>

<div class="row">
    <div class="col-md-10 center-block">


        @include('partials.frame.simple-top')

        <div class="list-group message-list">

            @forelse($messages as $message)

                @if( !$message->read() and $message->receiver->id == auth()->id() )
                    <div class="list-group-item message-item new">
                @else
                    <div class="list-group-item message-item">
                @endif
                <div class="row">

                    <div class="col-xs-6 col-sm-2 sender">
                        @if( $message->sender->id == auth()->id() )
                            {!! $message->receiver->showLink() !!}
                        @else
                            {!! $message->sender->showLink() !!}
                        @endif
                    </div>

                    <a href="{{route('message.show', $message->id)}}" class="messagelink">

                        <div class="col-xs-6 col-sm-2 pull-right date">
                            <time date="{{$message->date('created_at')->toDateTimeString()}}"
                                  title="{{$message->date('created_at')->toDayDateTimeString()}}">
                                {{$message->date('created_at')->diffForHumans()}}
                            </time>
                        </div>

                        <div class="col-xs-12 col-sm-8 subject">

                            @if( !$message->read() and $message->receiver->id == auth()->id() )
                                <strong>{{$message->subject()}}</strong>
                            @else
                                {{$message->subject()}}
                            @endif

                            <span class="summary">
                                -
                                {{str_limit( $message->content(), 60)}}
                            </span>
                        </div>
                    </a>

                </div>
            </div>
            @empty
                <div class="list-group-item message-item text-center">
                    <em>No messages...</em>
                </div>
            @endforelse

        @include('partials.frame.simple-bottom')

        </div>

        <div class="paginate">
            {!! $messages->links() !!}
        </div>

    </div>
</div>