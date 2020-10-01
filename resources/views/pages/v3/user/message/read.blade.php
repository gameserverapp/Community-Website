<?php
use GameserverApp\Helpers\SiteHelper;
use Illuminate\Support\Facades\Request;
?>

<?php
$user = auth()->user();

if(auth()->id() == $message->receiver->id) {
    $title = 'from ' . $message->sender->showLink();
} else {
    $title = 'to ' . $message->receiver->showLink();
}


?>

@extends('layouts.v3.default', [
    'page' => [
        'title' => translate('read_message', 'Read message'),
        'description' => 'Send a message to fellow players.',
        'class' => 'message read user-single'
    ]
])

@section('page_content')
    @include('pages.v3.user._header')

    <div class="row">
        <div class="col-md-8 center-block">

            <?php
            $title = $message->subject;

            $title = ucfirst($title) . ' &nbsp; <small class="label label-theme">' . $message->date('created_at')->diffForHumans() . '</small>';
            ?>

            @component('partials.v3.frame', ['type' => 'big' , 'title' => $title])


                {!! Markdown::convertToHtml($message->content()) !!}
            @endcomponent

            @if(auth()->id() != $message->sender->id)
                @if($message->receiver->canSendMessage())
                    @include('pages.v3.user.message._form', ['reply' => $message])
                @else
                    <div class="text-center">
                        <div class="alert alert-info">Replying to this message is disabled.</div>
                    </div>
                @endif
            @endif

        </div>
    </div>

@stop