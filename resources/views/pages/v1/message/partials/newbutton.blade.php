@if($contacts)

    <div class="btn-group new_message_button">

        <button type="button" class="btn champ small btn-default dropdown-toggle"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

            New message to <span class="caret"></span>
        </button>

        <ul class="dropdown-menu">

            @foreach( $contacts as $contact)
                <li>
                    <a href="{{route('message.create', $contact->id)}}">{!! $contact->showName() !!}</a>
                </li>
            @endforeach

        </ul>

    </div>

@endif