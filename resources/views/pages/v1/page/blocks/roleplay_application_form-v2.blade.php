{!! Markdown::convertToHtml($value) !!}

@if(auth()->check())
<form method="post" action="{{route('form.submit.old', ['roleplay_application_form'])}}" class="roleplay_application_form">
    {{csrf_field()}}
@endif

    @if(!auth()->check())
        <div class="alert alert-warning">
            Please login to submit your application.
        </div>
    @elseif(!auth()->user()->hasEmailSetup())
        <div class="alert alert-warning">
            Please <a href="{{route('user.settings', auth()->user()->id)}}">enter your e-mailaddress</a> to receive updates about your application.
        </div>
    @else
        <div class="alert alert-success">
            Updates about your application will be sent to your e-mailaddress.
        </div>
    @endif

    <table class="table">
        <tr>
            <td>
                <label>
                    Your Discord name + ID:
                </label>
            </td>
            <td>
                <input type="text" name="text-discord_name" value="{{old('text-discord_name')}}" required>
            </td>
        </tr>

        <tr>
            <td>
                <label>
                    Character first name:
                </label>
            </td>
            <td>
                <input type="text" name="text-character_first_name" value="{{old('text-character_first_name')}}" required>
            </td>
        </tr>

        <tr>
            <td>
                <label>
                    Character last name:
                </label>
            </td>
            <td>
                <input type="text" name="text-character_last_name" value="{{old('text-character_last_name')}}" required>
            </td>
        </tr>

        <tr>
            <td>
                <label>
                    Character class:
                </label>
            </td>
            <td>
                <input type="text" name="text-character_class" value="{{old('text-character_class')}}" required>
            </td>
        </tr>

        <tr>
            <td>
                <label>
                    Character description/backstory (min of 500 characters):
                </label>
            </td>
            <td>
                <textarea minlength="750" maxlength="3000" style="width:100%; height:80px;" name="textarea-character_backstory"  required>{{old('textarea-character_backstory')}}</textarea>
            </td>
        </tr>

        <tr>
            <td>
                <label>
                    Previous Roleplay experience:
                </label>
            </td>
            <td>
                <textarea style="width:100%; height:80px;" name="textarea-previous_roleplay_experience" required>{{old('textarea-previous_roleplay_experience')}}</textarea>
            </td>
        </tr>

        @if(auth()->check())
            <tr>
                <td>
                </td>
                <td>
                    <button type="submit" class="btn champ small"><span>Submit</span></button>
                </td>
            </tr>
        @endif
    </table>


@if(auth()->check())
    </form>
@endif