<article class=" ">
    <div class="container">

        @if(isset($block['title']))
        <header class="row rownav">
            <div class="col-md-12">
                <div>
                    <h1 class="text-center">{{ $block['title'] }}</h1>
                </div>
            </div>
        </header>
        @endif

        <div class="row tribe_list">
            <div class="col-md-12">
                <div class="slider owl-theme">

                    <?php
                    $count = 0;
                    $limit = 3;
                    ?>
                    @foreach( $tribes as $tribe )

                        @if($count == 0)
                            <div class="item">
                                <div class="content row">
                                    @endif

                                    <?php $count++; ?>

                                    <div class=" col-sm-4">
                                        @include('pages.v1.partials.tribe-card', [
                                            'tribe' => $tribe
                                        ])
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
    </div>
</article>