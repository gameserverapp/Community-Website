<div class="token-package">
    <a href="{{route('token.show', $package->id)}}">
        <img height="150" src="{{$package->image()}}" alt="{{$package->name()}}">

        <h2><span>{{$package->name()}}</span></h2>

        <p class="description">
            Tokens: <span>{{$package->quantity()}}</span> -
            <em>({{$package->currency()}} {{$package->tokenPrice()}} per token)</em>
        </p>
    </a>

    <a href="{{route('token.show', $package->id)}}" class="btn champ small dark inverted">
        {{--Buy for <span>{{$package->displayPrice()}}</span>--}}
        Order now &raquo;
    </a>
</div>