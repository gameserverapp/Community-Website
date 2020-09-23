<article class=" ">

    @if(isset($block['title']))
        <header class="row rownav">
            <div class="col-md-12">
                <div>
                    <h1 class="text-center">{{ $block['title'] }}</h1>
                </div>
            </div>
        </header>
    @endif

    <div class="row character_list">
        <div class="col-md-12">

            <div class="slider owl-theme">

                <?php
                $count = 0;
                $limit = 4;
                ?>
                @foreach( $characters as $character )

                    @if($count == 0)
                        <div class="item">
                            <div class="content">
                                @endif

                                <?php $count++; ?>

                                <div class="col-sm-6 col-md-3">
                                    @include('partials.v3.character-image')
                                </div>

                                @if( $count == $limit )
                            </div>
                        </div>
                        <?php $count = 0; ?>
                    @endif

                @endforeach

            </div>
        </div>

    </div>
</article>