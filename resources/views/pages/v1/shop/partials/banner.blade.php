<div class="col-md-8 text-only center-block">

    <h1>
        <div class="balance">
            @if(auth()->check())
                <a href="{{route('token.index')}}" class="btn champ inverted " >
                    Tokens
                    <div class="label label-default">{{auth()->user()->tokenBalance()}}</div>
                </a>
            @endif
        </div>

        <i class="fa fa-gift" aria-hidden="true"></i>
        Shop
    </h1>
</div>