@component('partials.v3.frame', ['class' => 'about', 'title' => $group->name()])
    <p>
        @if(!empty($group->about()))
            {!! nl2br(e($group->about())) !!}
        @else
            <em>Nothing here yet...</em>

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
                    'title' => translate('set_introduction', 'Set introduction'),
                    'route' => route('group.settings', $group->id),
                    'class' => 'center btn-theme-rock'
                ])
            @endif
        @endif
    </p>
@endcomponent