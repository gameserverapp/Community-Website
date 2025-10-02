@component('partials.v3.frame', [
    'title' => 'Connected accounts',
])

    <div class="row">
        <div class="col-md-8">
            <strong>{{auth()->user()->name()}}</strong>
            <span class="label label-default">
                    {{auth()->user()->serviceType()}}
                </span><br>
            <small style="font-size:12px;">{{auth()->user()->serviceId()}}</small>
        </div>
        <div class="col-md-4">

            <div style="padding-top:10px; text-align: center">
                <span class="label label-default">
                    Current login
                </span>
            </div>

        </div>
    </div>
    <hr>


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
                        'class' => 'center small',
                        'dusk' => 'disconnect'
                    ])

                    {!! Form::close() !!}

                </div>

            </div>
        </div>
        <hr>
    @empty
        <div class="alert alert-warning">
            There are no accounts connected to your current account yet.
        </div>
    @endforelse

    <div class="frame-footer">

        @if(
            auth()->user()->connect_users and
            count((array) auth()->user()->connect_users)
        )

            <label>Connect accounts</label><br>

            @foreach(auth()->user()->connect_users as $connectUser)

                <a class="btn btn-default openid-connect" dusk="connect-{{strtolower($connectUser->name)}}" href="{{$connectUser->connect_url}}">
                    <div>
                        <img width="100%" height="100%" src="{{$connectUser->icon}}">
                    </div>
                </a>

            @endforeach

            <hr>

        @endif

        {!! Form::model($user, ['route'=>['user.sub_user.connect'], 'method' => 'post']) !!}

        <h4>Alternative connect methods</h4>
        <p>
            When you cannot use the buttons above, you may be able to use one of the following methods.
        </p>
        <br>

        <label>
            <span class="label label-primary">Option 1</span>
            Enter connect code
        </label><br>
        <p>
            Request a connect code in-game, by typing <code>!getconnectcode</code> in chat (local or global). Enter the code you receive in the field below.
        </p>
        <div class="row getconnectcode">
            <div class="col-md-8">
                <input type="text" placeholder="Enter connect code here..." name="code" value="{{old('code')}}" class="form-control">
                <small>
                    <a href="https://docs.gameserverapp.com/dashboard/community/website#connect-sub-accounts-on-community-website" target="_blank">How to get connect code &raquo;</a>
                </small>
            </div>
            <div class="col-md-4">

                <div>
                    @include('partials.v3.button', [
                        'type' => 'submit',
                        'element' => 'button',
                        'title' => translate('Connect', 'Connect'),
                        'class' => 'center small'
                    ])
                </div>
            </div>
        </div>


        <hr>

        <label>
            <span class="label label-primary">Option 2</span>
            Reverse connect code
        </label><br>
        <p>
            Request a connect code on this page and enter it in-game.
        </p>

        <div>
            <button type="button" class="btn btn-primary small" data-toggle="modal" data-target="#reverseConnectCode">
                <span>
                    {{translate('Request connect code', 'Request connect code')}}
                </span>
            </button>
        </div>

        {!! Form::close() !!}
    </div>



@endcomponent


@push('modal_content')
    <!-- Modal -->
    <div class="modal fade" id="reverseConnectCode" tabindex="-1" role="dialog" aria-labelledby="reverseConnectCodeLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="reverseConnectCodeLabel">
                        Request connect code
                    </h4>
                </div>
                <div class="modal-body">

                    <div class="alert alert-danger">
                        <strong>Do not share this code with anyone!</strong><br>
                        This code can be used to connect your in-game account to this website account. Do not share this code with anyone.
                    </div>

                    <strong>How to use:</strong>

                    <ol>
                        <li>
                            Enter the username or account ID of the account you want to connect.
                        </li>
                        <li>
                            Click <code>Issue code</code> to generate a code.
                        </li>
                        <li>
                            Head in-game and type the code in the local or global chat.
                        </li>
                        <li>
                            Your in-game account is now connected to this website account.
                        </li>
                    </ol>

                    <div class="form-group">
                        <label>Username or Account ID</label><br>
                        <input type="text" class="form-control" placeholder="Enter username or account ID...">
                    </div>


                    <div class="output">
                        <em>Click <code>Issue code</code> to generate a code.</em>
                    </div>

                    <div id="codeResult" style="display: none;">
                        <div class="form-group">
                            <label>Generated Code</label>
                            <div class="input-group">
                                <input type="text" id="generatedCode" class="form-control" readonly>
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default" id="copyCode">
                                        Copy
                                    </button>
                                </span>
                            </div>
                            <small class="text-muted">This code is valid for 3 minutes. Copy and paste it in-game.</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary small" id="issueCode">
                        Issue code
                    </button>
                </div>

                <script>
                    $(document).ready(function() {
                        $('#issueCode').click(function() {
                            var $button = $(this);
                            var $statusDiv = $('.output');
                            var $codeResult = $('#codeResult');
                            var $input = $('.form-group input[type="text"]');
                            var accountId = $input.val().trim();

                            if (!accountId) {
                                $statusDiv.html('<div class="alert alert-warning">Please enter a username or account ID first.</div>');
                                $codeResult.hide();
                                return;
                            }

                            $button.prop('disabled', true).text('Generating...');
                            $codeResult.hide();

                            $.get("{{route('user.sub_user.issue_reverse_code')}}", {
                                account_id: accountId
                            })
                                .done(function(data) {
                                    if (data.success) {
                                        $statusDiv.html('<div class="alert alert-success">Code generated successfully!</div>');
                                        $('#generatedCode').val(data.success);
                                        $codeResult.show();
                                    } else if (data.error) {
                                        $statusDiv.html('<div class="alert alert-danger">' + data.error + '</div>');
                                    } else {
                                        $statusDiv.html('<div class="alert alert-danger">Unexpected response format.</div>');
                                    }
                                })
                                .fail(function(xhr) {
                                    $statusDiv.html('<div class="alert alert-danger">Failed to generate code. Please try again.</div>');
                                })
                                .always(function() {
                                    $button.prop('disabled', false).text('Issue code');
                                });
                        });

                        $('#copyCode').click(function() {
                            var $input = $('#generatedCode');
                            $input.select();
                            document.execCommand('copy');

                            var $button = $(this);
                            var originalText = $button.text();
                            $button.text('Copied!');
                            setTimeout(function() {
                                $button.text(originalText);
                            }, 2000);
                        });
                    });
                </script>
            </div>
        </div>
    </div>
@endpush