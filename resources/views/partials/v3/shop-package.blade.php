<div class="purchase-package package-small">
    @if($item->cluster)
        <div class="label label-theme">
            {{$item->cluster}} only
        </div>
    @endif
    <a href="{{route('shop.show', $item->id)}}">
        <div class="image-container">
            <img src="{{$item->image()}}" alt="{{$item->name()}}">
        </div>

        <h4 class="title"><span>{{str_limit($item->name(), 20)}}</span></h4>
{{--        <div class="costs">--}}
{{--            <span>{{$item->tokenPrice()}} tokens</span>--}}
{{--        </div>--}}

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
    </a>

{{--    <a class="link" href="{{route('shop.show', $item->id)}}">{{translate('details', 'Details')}} &raquo;</a>--}}

    @include('partials.v3.button', [
        'route' => route('shop.show', $item->id),
        'title' => translate('details', 'Details'),
        //'class' => 'btn-theme-gem'
    ])
</div>