@if($item)

    <?php
    $stRoute = route('supporter-tier.show', $item->id);

    if($coupon = request('coupon')) {
        $stRoute = $stRoute . '?coupon=' . $coupon;
    }
    ?>

    <div class="purchase-package tier">
        @if($label = $item->label())
            <div class="label label-theme top-left">
                {!! $label !!}
            </div>
        @endif
        <a href="{{$stRoute}}">
            <div class="image-container">
                <img src="{{$item->image()}}" alt="{{$item->name()}}">
            </div>

            <h4 class="title"><span>{{str_limit($item->name(), 30)}}</span></h4>

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