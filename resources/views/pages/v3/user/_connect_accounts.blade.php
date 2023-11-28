@component('partials.v3.frame', [
    'title' => 'Connected accounts',
])

    @forelse(auth()->user()->sub_users as $subUser)
        <div class="row">
            <div class="col-md-8">
                <strong>{{$subUser->name()}}</strong>
                <span class="label label-default">
                    {{$subUser->serviceType()}}
                </span><br>
                <small style="font-size:12px;">{{$subUser->serviceId()}}</small>
            </div>
            <div class="col-md-4">

                <div style="padding-top:10px;">

                    {!! Form::model($subUser, ['route'=>['user.sub_user.disconnect', $subUser->id], 'method' => 'post']) !!}

                    @include('partials.v3.button', [
                        'type' => 'submit',
                        'element' => 'button',
                        'title' => translate('disconnect', 'Disconnect'),
                        'class' => 'center small'
                    ])

                    {!! Form::close() !!}

                </div>

            </div>
        </div>
        <hr>
    @empty
        <p>
            There are no accounts connected to your current account yet.<br>

            <a href="https://docs.gameserverapp.com/dashboard/community/website#connect-sub-accounts-on-community-website" target="_blank">How to get connect code &raquo;</a>
        </p>
    @endforelse



    <div class="frame-footer">
    {!! Form::model($user, ['route'=>['user.sub_user.connect'], 'method' => 'post']) !!}

        <div class="row">
            <div class="col-md-8">
                <label>Enter connect code</label><br>
                <input type="text" name="code" value="{{old('code')}}" class="form-control">
                <small>
                    <a href="https://docs.gameserverapp.com/dashboard/community/website#connect-sub-accounts-on-community-website" target="_blank">How to get connect code &raquo;</a>
                </small>
            </div>
            <div class="col-md-4">

                <div style="padding-top:29px;">
                    @include('partials.v3.button', [
                        'type' => 'submit',
                        'element' => 'button',
                        'title' => translate('Connect', 'Connect'),
                        'class' => 'center small'
                    ])
                </div>
            </div>
        </div>

    {!! Form::close() !!}
    </div>

@endcomponent