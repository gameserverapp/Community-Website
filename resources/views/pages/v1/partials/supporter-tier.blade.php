<div class="package">
    @if($tier->cluster)
        <div class="label label-donor">{{$tier->cluster}} only</div>
    @endif
    <a href="{{route('supporter-tier.show', $tier->id)}}">
        <img height="150" src="{{$tier->image()}}" alt="{{$tier->name()}}">

        <h2><span>{{str_limit($tier->name(), 20)}}</span></h2>
        <div class="costs">
            <span>{{$tier->displayTotalPrice()}}</span>
        </div>
    </a>

    <a href="{{route('supporter-tier.show', $tier->id)}}" class="btn champ small dark inverted">
{{--        Buy for <span>{{$tier->displayTotalPrice()}}</span>--}}
        More info &raquo;
    </a>
</div>