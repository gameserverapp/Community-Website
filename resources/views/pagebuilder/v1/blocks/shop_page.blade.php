@php
    use GameserverApp\Transformers\ShopTransformer;
    use Illuminate\Pagination\LengthAwarePaginator;
@endphp
<article class="shop_page">

    <div class="row">

        <div class="col-md-12 text-center">

            <div class="row">
                <div class="col-md-4 hidden-xs">
                </div>
                <div class="col-md-4 col-xs-8">
                    <form method="get">
                        <input type="search" name="search" value="{{request()->get('search')}}" placeholder="Search...">
                        <input type="hidden" name="cluster" value="{{request()->get('cluster')}}">
                        <input type="hidden" name="gameserver" value="{{request()->get('gameserver')}}">
                        <input type="hidden" name="filter" value="{{request()->get('filter')}}">
                    </form>
                </div>
                <div class="col-md-4 col-xs-4">

                    @if($block['filters']['labels'])
                        <select onchange="if (this.value) window.location.href=this.value">
                            <option value="?search={{request()->get('search')}}">No filter</option>

                            @foreach($block['filters']['labels'] as $uuid => $name)
                                <option @if(urlencode(request()->get('filter')) == $uuid) selected @endif value="?search={{request()->get('search')}}&filter={{$uuid}}">{{$name}}</option>
                            @endforeach
                        </select>
                    @endif
                </div>
            </div>

        </div>
    </div>
    <br>
    @if(request()->has('search'))
        <div class="row">
            <div class="col-md-8 center-block text-center">
                <h3 class="title">
                    Results for "{{request()->get('search')}}"
                </h3>
            </div>
        </div>
    @endif
    <div class="row">
        <?php
        $itemsObj = json_decode(json_encode($block['packs']['items']));
        $items = ShopTransformer::transformMultiple($itemsObj);

        $pagination = new LengthAwarePaginator(
            $items,
            $block['packs']['total'],
            $block['packs']['per_page'],
            $block['packs']['current_page'],
            [
                'path' => request()->url()
            ]
        );
        ?>

        @forelse( $items as $pack )

            <div class="col-md-4 col-lg-3">
                @include('partials.v3.shop-package', [
                    'item' => $pack
                ])
            </div>

        @empty
            <div class="col-md-12">
                <div class="text-center">
                    <em>No packages available</em>
                </div>
            </div>
        @endforelse

    </div>

    <div class="row">
        <div class="paginate">
            {!! $pagination->appends([
                'search' => request()->get('search'),
                'filter' => request()->get('filter')])->links() !!}
        </div>
    </div>
</article>