@component('partials.v3.frame', ['class' => 'motd', 'title' => 'Message of the Day'])
    <p>
        @if(!empty($group->motd()))
            {!! nl2br(e($group->motd())) !!}
        @else
            <em>Nothing here yet...</em>
        @endif

        @if(
                auth()->check() and
                auth()->user()->isGroupMember($group) and
                (
                    $group->isOwner(auth()->user()) or
                    $group->isAdmin(auth()->user())
                )
            )
            <br><br><br>
            @include('partials.v3.button', [
                'title' => translate('setmotd', 'Set MOTD'),
                'route' => route('group.settings', $group->id),
                'class' => 'center btn-theme-rock'
            ])
        @endif
    </p>
@endcomponent