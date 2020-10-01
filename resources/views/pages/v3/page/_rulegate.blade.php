

    @isset($top)
        <div class="rulegate">
            <div class="container rulegate-form-alert">
                <div class="row">
                    <div class="col-md-8 center-block text-center">
                        <div class="alert alert-warning">
                            Please scroll down to accept the rules.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endisset

    @isset($bottom)
        <div class="rulegate bg">
            <div class="container rulegate-form">
                <div class="row">
                    <div class="col-md-8 center-block text-center">
                        {!! Form::open(['route'=> ['user.accept_rules', auth()->id()], 'method' => 'post']) !!}
                        {!! Form::submit('Yes, I understand and will respect the rules!', array('class' => 'btn btn-theme btn-theme-basic')) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    @endisset
