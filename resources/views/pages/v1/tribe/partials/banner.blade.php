{!! $tribe->showLink(['disable_link' => true]) !!}

@if(
    auth()->check() and
    !auth()->user()->isTribeMember($tribe) and
    $tribe->hasOwners()
 )
    <div class="promote">
        <a class="btn champ inverted small" href="{{route('message.create', $tribe->owner_id)}}">
            send application &raquo;
        </a>
    </div>
@endif