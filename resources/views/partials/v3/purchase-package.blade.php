@if($item)

    <?php
    $stRoute = route('supporter-tier.show', $item->id);

    if($coupon = request('coupon')) {
        $stRoute = $stRoute . '?coupon=' . $coupon;
    }
    ?>

    <div class="purchase-package tier">
        @if($item->hasLabel())
            <div class="label-container">
                @if(is_array($item->label()))
                    @foreach($item->label() as $label)
                        <div class="label label-theme top-left">{{$label}}</div>
                    @endforeach
                @else
                    <div class="label label-theme top-left">{{$item->label()}}</div>
                @endif
            </div>
        @endif
        <a href="{{$stRoute}}">
            <div class="image-container">
                <img src="{{$item->image()}}" alt="{{$item->name()}}">
            </div>

            <h4 class="title"><span>{{str_limit($item->name(), 30)}}</span></h4>

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
                <span>{!! $item->displayTotalPrice() !!}</span>
            </div>
        </a>

        @include('partials.v3.button', [
            'route' => $stRoute,
            'title' => translate('details', 'Details')
        ])
    </div>
@endif