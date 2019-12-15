<div class=" center-block col-md-10">
    <ul class="nav nav-tabs">


        <li class="right">
            <a href="{{route('token.buy')}}">
                Get more tokens
            </a>
        </li>

        <li class="right {{ GameserverApp\Helpers\RouteHelper::isCurrentRoute('shop.orders') ? 'active' : '' }}">
            <a href="{{route('shop.orders')}}">
                Orders
            </a>
        </li>

        @if(!GameserverApp\Helpers\RouteHelper::isCurrentRoute('shop.index'))
            <li class="right {{ GameserverApp\Helpers\RouteHelper::isCurrentRoute('shop.index') ? 'active' : '' }}">
                <a href="{{route('shop.index')}}">
                    Supplies
                </a>
            </li>
        @endif

    </ul>
</div>