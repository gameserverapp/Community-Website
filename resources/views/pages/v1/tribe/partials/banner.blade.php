{!! $tribe->showLink(['disable_link' => true]) !!}

@if(
    auth()->check() and
    !auth()->user()->isTribeMember($tribe) and
    $tribe->hasOwners()
 )
    <div class="promote">
        <a class="btn champ inverted small" href="{{route('message.create', $tribe->owners->first()->id)}}">
            send application &raquo;
        </a>
    </div>
@endif