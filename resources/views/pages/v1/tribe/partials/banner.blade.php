{!! $tribe->showLink(['disable_link' => true]) !!}

@if(
    auth()->check() and
    !auth()->user()->isGroupMember($tribe) and
    $tribe->hasOwners()
 )
    <div class="promote">
        <a class="btn champ inverted small" href="{{route('message.create', $tribe->owners[0])}}">
            send application &raquo;
        </a>
    </div>
@endif