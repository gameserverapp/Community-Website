@if($item)
    <div class="purchase-package">
        @if($item->cluster)
            <div class="label label-theme">
                {{$item->cluster}} only
            </div>
        @endif
        <a href="{{route('supporter-tier.show', $item->id)}}">
            <div class="image-container">
                <img src="{{$item->image()}}" alt="{{$item->name()}}">
            </div>

            <h2 class="title"><span>{{str_limit($item->name(), 20)}}</span></h2>
            <div class="costs">
                <span>{{$item->displayTotalPrice()}}</span>
            </div>
        </a>

        @include('partials.v3.button', [
            'route' => route('supporter-tier.show', $item->id),
            'title' => translate('details', 'Details')
        ])
    </div>
@endif