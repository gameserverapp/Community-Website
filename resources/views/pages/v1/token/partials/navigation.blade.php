<div class=" center-block col-md-10">
    <ul class="nav nav-tabs">

        <li class="{{ GameserverApp\Helpers\RouteHelper::isCurrentRoute('token.index') ? 'active' : '' }}">
            <a href="{{route('token.index')}}">
                Transactions
            </a>
        </li>

        <li class="right {{ GameserverApp\Helpers\RouteHelper::isCurrentRoute('token.buy') ? 'active' : '' }}">
            <a href="{{route('token.buy')}}">
                Get more tokens
            </a>
        </li>

    </ul>
</div>