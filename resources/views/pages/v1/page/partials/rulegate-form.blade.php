<div class="container rulegate-form">
    <div class="row defaultcontent">
        <div class="col-md-8 center-block text-center">
            {!! Form::open(['route'=> ['user.accept_rules', auth()->id()], 'method' => 'post']) !!}
            {!! Form::submit('Yes, I understand and will respect the rules!', array('class' => 'btn champ')) !!}
            {!! Form::close() !!}
        </div>
    </div>
</div>

<div class="container rulegate-form-scroller">
    <div class="row defaultcontent">
        <div class="col-md-8 center-block text-center">
            <div class="alert alert-warning">
                Please scroll down to accept the rules.
            </div>
        </div>
    </div>
</div>
