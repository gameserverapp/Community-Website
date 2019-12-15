<div class="package-category">

    <a href="{{route('shop.show', $pack->id)}}">
        <img height="127" src="{{$pack->image()}}" alt="{{$pack->name()}}">
    </a>

    <h2>
        <a href="{{route('shop.show', $pack->id)}}">{{$pack->name(24)}}</a>
    </h2>

    <div class="btn-group">

        <a href="{{route('shop.show', $pack->id)}}" class="btn champ small single inverted">Order now ({{$pack->displayTokenPrice()}})</a>
    </div>
</div>