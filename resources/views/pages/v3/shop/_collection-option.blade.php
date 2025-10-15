@component('partials.v3.frame', [
    //'type' => 'basic'
    'class' => 'collection-option-parent'
])

<?php
$formId = md5($item->orderUrl());

if($item->hasLabel()) {
    $label = $item->label(false);
} else {
    $label = '-1';
}
?>

<form class="collection-option" method="post" action="{{$item->orderUrl()}}" id="{{$formId}}" data-label="{{$label}}"  >
    {{csrf_field()}}
    <div class="row">
        <div class="col-sm-3 col-lg-2">
            <div class="main-image">

                @if($item->hasLabel())
                    <div class="label label-theme top-left">
                        {{$item->label()}}
                    </div>
                @endif

                <img src="{{$item->image()}}">
            </div>
        </div>
        <div class="col-sm-9 col-lg-10">
            <div class="main-title">

                <h2 class="title">
                    <span class="js-collection-option-title">
                        {{$item->name()}}
                    </span>
                </h2>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <span class="js-collection-option-description">
                {!! Markdown::convertToHtml($item->description()) !!}
            </span>

            @if($item->cluster)
                <div class="alert alert-warning">
                    <span>
                        <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                        Only deliverable on the <strong>{{$item->cluster}}</strong> cluster!
                    </span>
                </div>
            @endif

            @if($item->gameserver)
                <div class="alert alert-warning">
                    <span>
                        <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                        Only deliverable on the <strong>{{$item->gameserver}}</strong> server!
                    </span>
                </div>
            @endif
        </div>
        <div class="col-lg-4">



            @if($item->tokenPrice() > 0)
                <div class="text-center">
                    <h4>
                        Price
                        @if($item->hasLabel())
                            <div class="label label-theme top-left">
                                {{$item->label()}}
                            </div>
                        @endif
                    </h4>

                    <p>
                        <strong>
                            {!! $item->displayTokenPrice() !!}
                        </strong>
                    </p>
                </div>
            @endif

            <div class="row">
                <div class="col-md-12 col-sm-6 col-xs-12">
                    <?php
                    $percentage = calcPercentage($item->limit(), $item->usage());
                    ?>
                    <div class="progress">
                        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20" aria-valuemin="0"
                             aria-valuemax="100" style="width: {{$percentage}}%">
                        </div>

                        <div class="detail">
                            {{$item->displayLimits()}}

                            @if($item->limit())
                                <i>({{$percentage}}%)</i>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-12 col-sm-6 col-xs-12">
                    @if(!auth()->check())
                        <div class="alert alert-info">
                            Login to order.
                        </div>
                    @elseif($item->requiresDiscordConnected() and !auth()->user()->hasDiscordSetup())
                        <div class="alert alert-warning">
                            You need to <a href="{{route('user.settings', auth()->user()->id)}}">connect your Discord</a> to order this package.
                        </div>
                    @elseif($item->requiresCharacterSelect())
                        @if($item->hasCharacters())
                            <div class="text-center">
                                <label>Deliver to:</label>
                                <select name="character_id">
                                    @foreach($item->characters() as $character)
                                        <option @if($character->online()) selected @endif value="{{$character->id}}">
                                            {{$character->name()}}

                                            @if($character->online()) [online] @endif

                                            @if($character->hasServer())
                                                ({{$character->server->name}})
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            @include('partials.v3.button_with_confirm_modal', [
                                'title' => 'Order now &raquo;',
                                'class' => 'btn-theme-rock center',
                                'confirm_modal' => [
                                    'title' => 'Confirm your purchase',
                                    'text' => 'Are you sure you want to buy "<strong>' . $item->name() . '</strong>" for ' . $item->displayTokenPriceTextOnly() . '?',
                                    'form_id' => $formId
                                ],
                                'dusk' => 'order-now'
                            ])
                        @else
                            <div class="alert alert-danger">
                                You do not have a character to deliver this shop pack to.
                            </div>
                        @endif
                    @elseif($item->requiresGameServerSelect())
                        @if($item->hasGameServers())
                            <div class="text-center">
                                <label>Deliver on:</label>
                                <select name="gameserver_id">
                                    @foreach($item->gameservers() as $gameserver)
                                        <option value="{{$gameserver->id}}" @if(old('gameserver_id') == $gameserver->id) selected @endif>
                                            {{$gameserver->name()}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            @include('partials.v3.button_with_confirm_modal', [
                                'title' => 'Order now &raquo;',
                                'class' => 'btn-theme-rock center',
                                'confirm_modal' => [
                                    'title' => 'Confirm your purchase',
                                    'text' => 'Are you sure you want to buy "<strong>' . $item->name() . '</strong>" for ' . $item->displayTokenPriceTextOnly() . '?',
                                    'form_id' => $formId
                                ],
                                'dusk' => 'order-now'
                            ])
                        @else
                            <div class="alert alert-danger">
                                There are no game servers to deliver this shop pack on.
                            </div>
                        @endif
                    @else
                        @include('partials.v3.button_with_confirm_modal', [
                            'title' => 'Order now &raquo;',
                            'class' => 'btn-theme-rock center',
                            'confirm_modal' => [
                                'title' => 'Confirm your purchase',
                                'text' => 'Are you sure you want to buy "<strong>' . $item->name() . '</strong>" for ' . $item->displayTokenPriceTextOnly() . '?',
                                'form_id' => $formId
                            ],
                            'dusk' => 'order-now'
                        ])
                    @endif
                </div>
            </div>

        </div>
    </div>
</form>
@endcomponent