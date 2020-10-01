<form method="post" action="{{route('group.settings.save', $group->id)}}">
    {{csrf_field()}}

    @component('partials.v3.frame', ['title' => 'Settings'])
        <div class="form-group">
            <label>Message of the Day</label>
            <p>
                Remind your team about objectives and more.<br>
                The message will show up in-game when you or one of your fellow members logs in.
            </p>
            <p>
                The Message of the Day is only visible to group members.
            </p>
            <textarea style="height:70px;" name="motd" class="form-control" placeholder="Lets gooo!!" maxlength="290">{{old('motd', $group->motd())}}</textarea>
        </div>
        <hr>
        <div class="form-group">
            <label>About your group</label>
            <p>
                Introduce your group to people visiting your group page and leave the right impression.
            </p>
            <textarea style="height:150px;" name="about" class="form-control" placeholder="Hi! We're a new friendly group willing to help out. Send a message!">{{old('about', $group->about())}}</textarea>
        </div>

        <br>

        @include('partials.v3.button', [
            'type' => 'submit',
            'element' => 'button',
            'title' => translate('save_settings', 'Save settings'),
            'class' => 'center'
        ])
    @endcomponent

</form>