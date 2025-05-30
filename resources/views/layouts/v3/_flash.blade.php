<?php
try {
    ?>
    @if ( isset( $errors ) and count($errors) > 0)
        <div class="flash alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    @if(is_array($error))
                        @foreach($error as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    @else
                        <li>{{ $error }}</li>
                    @endif
                @endforeach
            </ul>
        </div>
    @endif

    @if(
        (
            Session::has('alert') and
            is_array(Session::get('alert'))
        ) or
        (
            Session::has('alerts') and
            is_array(Session::get('alerts'))
        )
    )
        <?php
        if( Session::has('alerts') ) {
            $error_msg = Session::get('alerts');
        } else {
            $error_msg = Session::get('alert');
        }

        if( !isset( $error_msg['status'] ) ) {

            $error_msg = $error_msg[0];

            if( isset( $error_msg['type'] ) ) {
                $error_msg['status'] = $error_msg['type'];
            }
        }

        Session::forget('alerts');
        Session::forget('alert');
        ?>
        <div class="flash alert alert-{{$error_msg['status'] ?? 'info'}}  @if( $error_msg['status'] != 'error' and !isset( $error_msg['stay'] ) ) alert-dismissible @endif">
            @if( $error_msg['status'] != 'error' and !isset( $error_msg['stay'] ) )
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            @endif

            {!! $error_msg['message'] ?? ''!!}
        </div>
    @endif
<?php
} catch(Exception $e) {

}