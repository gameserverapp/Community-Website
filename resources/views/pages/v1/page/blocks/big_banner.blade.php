<div class="big_banner">
    <div class="content-wrapper">
        <h1>{{$value}}</h1>

        @isset($block['subtitle'])
            <h2>{{$block['subtitle']}}</h2>
        @endif

        @if(isset($block['button_text']) and isset($block['button_url']))
            <div class="button-wrapper">

            </div>
        @endif
    </div>
</div>