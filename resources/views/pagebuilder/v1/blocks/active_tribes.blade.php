<article class="active-tribes">
    @if(isset($block['title']))
        <header class="row">
            <div class="col-md-12 text-center">
                <h1>{{ $block['title'] }}</h1>
            </div>
        </header>
    @endif

    <div class="row">
        <div class="col-md-12">
            <div class="slider owl-theme">

                <?php
                $count = 0;
                $limit = 3;
                ?>
                @foreach( $tribes as $group )

                    @if($count == 0)
                        <div class="item">
                            <div class="content row">
                                @endif

                                <?php $count++; ?>

                                <div class=" col-sm-4">
                                    @include('partials.v3.group-card', [
                                        'group' => $group
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
</article>