<div class="big_banner">
    <div class="content-wrapper">
        <h1>{{$value}}</h1>

        @isset($block['subtitle'])
            <h2>{{$block['subtitle']}}</h2>
        @endif

        @if(isset($block['button_text']) and isset($block['button_url']))
            <div class="button-wrapper">
                <a href="{{$block['button_url']}}" class="btn btn-theme">
                    <span>{{$block['button_text']}}</span>
                </a>
            </div>
        @endif
    </div>
</div>