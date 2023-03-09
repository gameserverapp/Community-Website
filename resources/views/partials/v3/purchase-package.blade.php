@if($item)
    <div class="purchase-package tier">
        @if($label = $item->label())
            <div class="label label-theme">
                {!! $label !!}
            </div>
        @endif
        <a href="{{route('supporter-tier.show', $item->id)}}">
            <div class="image-container">
                <img src="{{$item->image()}}" alt="{{$item->name()}}">
            </div>

            <h4 class="title"><span>{{str_limit($item->name(), 30)}}</span></h4>

            <div class="costs">
                <span>{!! $item->displayTotalPrice() !!}</span>
            </div>
        </a>

        @include('partials.v3.button', [
            'route' => route('supporter-tier.show', $item->id),
            'title' => translate('details', 'Details')
        ])
    </div>
@endif