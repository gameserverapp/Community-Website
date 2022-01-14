@if(auth()->check())
    <form method="post" action="{{route('form.submit', $block['id'])}}">
        {{csrf_field()}}
@endif

<?php
$footer = '<button type="submit" ' . (!auth()->check() ? 'disabled' : '' ) . ' class="btn btn-theme small"><span>Submit</span></button>';
?>

@component('partials.v3.frame', ['title' => $block['name'], 'class' => 'formbuilder no-bottom-margin', 'footer' => $footer])

    @if(!auth()->check())
        <div class="alert alert-warning">
            Please <a href="{{route('auth.login')}}">login</a> to submit this form.<br>
            You will be requested to log into your steam account, so we can verify you own the Steam account.
        </div>
    @elseif(
        isset($block['form_type']) and
        $block['form_type'] == 'whitelist-application'
    )
        @if(
            (
                !auth()->user()->hasEmailSetup() or
                !auth()->user()->emailConfirmed()
            ) and
            isset($block['email_required']) and
            $block['email_required']
        )
            <div class="alert alert-warning">
                <i class="fa fa-exclamation-triangle" style="display:inline-block" aria-hidden="true"></i>
                <span style="display:inline-block">
                    You must have a confirmed <a href="{{route('user.settings', auth()->user()->id)}}">email address setup</a> to submit this form. <em><a href="{{route('user.settings', auth()->user()->id)}}">Privacy information</a></em>
                </span>
            </div>
        @elseif(
            auth()->user()->hasEmailSetup() and
            auth()->user()->emailConfirmed()
        )
            <div class="alert alert-success">
                Updates are sent to your email address.
            </div>
        @endif

        @if(!auth()->user()->hasDiscordSetup())
            <div class="alert alert-warning">
                <i class="fa fa-exclamation-triangle" style="display:inline-block" aria-hidden="true"></i>
                Please <a href="{{route('user.settings', auth()->user()->id)}}">connect your Discord</a> to continue.
            </div>
        @endif
    @endif

    @if(isset($block['description']) and !empty($block['description']))
        {!! Markdown::convertToHtml($block['description']) !!}
        <hr>
    @endif

    <div class="form">
        @include('partials.form.index', [
            'content' => json_decode($value, true)
        ])
    </div>

@endcomponent

@if(auth()->check())
    </form>
@endif