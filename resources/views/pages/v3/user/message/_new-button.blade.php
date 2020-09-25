<div class="btn-group">
    <button type="button" class="btn btn-theme btn-theme-rock dropdown-toggle"
            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <span>
             New message &nbsp;
            <i class="caret"></i>
        </span>
    </button>
    <ul class="dropdown-menu">

        @foreach( $contacts as $contact)
            <li>
                <a href="{{route('message.create', $contact->id)}}">{!! $contact->showName() !!}</a>
            </li>
        @endforeach

    </ul>
</div>