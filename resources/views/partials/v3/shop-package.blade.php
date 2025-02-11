@if($item)
    <div class="purchase-package package-small package-id-{{$item->id}}">
        @if($item->cluster)
            <div class="label label-theme top-left">
                {{$item->cluster}} only
            </div>
        @elseif($item->gameserver)
            <div class="label label-theme top-left">
                {{$item->gameserver}} only
            </div>
        @elseif($item->hasLabel())
            <div class="label label-theme top-left">
                {{$item->label()}}
            </div>
        @endif
        <a href="{{route('shop.show', $item->id)}}">
            <div class="image-container">
                <img src="{{$item->image()}}" alt="{{$item->name()}}">
            </div>


            <h4 class="title"><span>{{$item->name()}}</span></h4>

            @if($item->isSingle())

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

                <div class="costs">
                    <span>{!! $item->displayTokenPrice() !!}</span>
                </div>
            @elseif($item->isCollection())
                <div class="collection">
                    <div class="label label-theme">Collection</div>
                </div>
            @endif
        </a>

    {{--    <a class="link" href="{{route('shop.show', $item->id)}}">{{translate('details', 'Details')}} &raquo;</a>--}}
        <?php
        $text = translate('details', 'Details');

        if($item->isCollection()) {
            $text = translate('see_items', 'See items');
        }
        ?>
        @include('partials.v3.button', [
            'route' => route('shop.show', $item->id),
            'title' => $text,
            //'class' => 'btn-theme-gem'
        ])
    </div>
@endif
