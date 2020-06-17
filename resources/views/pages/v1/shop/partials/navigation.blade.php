<div class=" center-block col-md-10">
    <ul class="nav nav-tabs">


        <li class="right">
            <a href="{{route('supporter-tier.index')}}">
                Supporter Tiers
            </a>
        </li>

        <li class="right {{ GameserverApp\Helpers\RouteHelper::isCurrentRoute('shop.orders') ? 'active' : '' }}">
            <a href="{{route('shop.orders')}}">
                Order history
            </a>
        </li>

        @if(!GameserverApp\Helpers\RouteHelper::isCurrentRoute('shop.index'))
            <li class="right {{ GameserverApp\Helpers\RouteHelper::isCurrentRoute('shop.index') ? 'active' : '' }}">
                <a href="{{route('shop.index')}}">
                    Shop
                </a>
            </li>
        @endif

    </ul>
</div>