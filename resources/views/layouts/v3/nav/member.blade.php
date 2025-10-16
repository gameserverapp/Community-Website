<?php
use GameserverApp\Helpers\SiteHelper;
?>
<div class="dropdown" dusk="topnav">
    <span class="btn btn-default btn-small dashboard" data-toggle="dropdown"
       aria-haspopup="true" aria-expanded="true">
        {!! auth()->user()->showLink(['disable_link' => true]) !!}
        <span class="caret"></span>
    </span>
    <ul class="dropdown-menu">

        <?php
        if(auth()->user()->hasCharacters()) {
            $navChar = auth()->user()->lastCharacter();

            if($navChar) {
                ?>

                @if(SiteHelper::featureEnabled('character_page'))
                    <li>
                        <a href="{{route('character.show', $navChar->id)}}" class="charview {{ GameserverApp\Helpers\RouteHelper::isCurrentRoute('character.show', $navChar->id) ? 'orange' : '' }}">
                                <span>
                                    {!! $navChar->showLink(['disable_link' => true]) !!}
                                </span>
                            &nbsp;
                            <div class="char_pic"
                                 style="background-image:url('{{$navChar->image()}}')"></div>
                        </a>
                    </li>
                    <li role="separator" class="divider"></li>
                @endif

                @if(SiteHelper::featureEnabled('tribe_page'))

                    @if($navChar->hasGroup())
                        <?php
                        $groups = auth()->user()->lastCharacter()->groups;
                        ?>

                        @foreach($groups as $group)
                            <li>
                                <a href="{{$group->showRoute()}}"  class="{{ GameserverApp\Helpers\RouteHelper::isCurrentRoute('group.show', $group->id) ? 'orange' : '' }}">
                                    {!! $group->showName() !!}

                                    @if($group->hasServer())
                                        &nbsp;
                                        &nbsp;
                                        <span class="label label-default">
                                            {{$group->server->name()}}
                                        </span>
                                    @endif
                                </a>
                            </li>
                            @if($navChar->groupAdmin($group))
                                <li>
                                    <a href="{{route('group.settings', $group->id)}}">
                                        Group settings
                                    </a>
                                </li>
                            @endif

                            <li role="separator" class="divider"></li>
                        @endforeach
                    @elseif($navChar)
                        <li>
                            <a href="/{{GameserverApp\Helpers\RouteHelper::inspector()}}?search_type=tribe" class="{{Request::is('inspector*') ? 'orange' : ''}}">
                                Find a {{ GameserverApp\Helpers\SiteHelper::groupName()}} &raquo;
                            </a>
                        </li>

                    <li role="separator" class="divider"></li>
                    @endif

                @endif

                <?php
            }
        }
        ?>

        @if(SiteHelper::featureEnabled('shop'))
            <li>
                <a dusk="topnav-shop" href="{{route('shop.index')}}" class="{{Request::is('shop*') ? 'orange' : '' }}">
                    <i class="fa fa-gift" aria-hidden="true"></i> &nbsp;
                    Reward shop
                </a>
            </li>
        @endif

        @if(SiteHelper::featureEnabled('supporter_tiers'))
            <li>
                <a dusk="topnav-supporter-tiers" href="{{route('supporter-tier.index')}}" class="{{ Request::is('supporter-tier*')  ? 'orange' : '' }}">
                    <i class="fa fa-trophy" aria-hidden="true"></i> &nbsp;
                    Supporter Tiers
                </a>
            </li>
        @endif


        @if(
            SiteHelper::featureEnabled('supporter_tiers') or
            SiteHelper::featureEnabled('shop')
        )
            <li role="separator" class="divider"></li>
        @endif

        @if(SiteHelper::featureEnabled('user_page'))
            <li>
                <a dusk="topnav-account" href="{{route('user.show', auth()->id())}}" class="{{ GameserverApp\Helpers\RouteHelper::isCurrentRoute('user.activity', auth()->id()) ? 'orange' : '' }}">
                    Account profile
                </a>
            </li>
        @endif

        @if(SiteHelper::featureEnabled('messages'))
            <li class="hidden-sm">
                <a dusk="topnav-messages" href="{{route('message.index')}}"
                   class="inbox {{ Request::is('user/me/message*') ? 'orange' : '' }}">
                    Messages
                    <span class="label label-default right">
                       {{auth()->user()->unreadMessagesCount()}}
                    </span>
                </a>
            </li>
        @endif

        @if(SiteHelper::featureEnabled('tokens'))
            <li>
                <a dusk="topnav-tokens" href="{{route('token.index')}}" class="{{ GameserverApp\Helpers\RouteHelper::isCurrentRoute('token.index') ? 'orange' : '' }}">
                    Tokens
                    <span class="label label-default right">
                    {{auth()->user()->tokenBalance()}}
                </span>
                </a>
            </li>
        @endif


        @if(SiteHelper::featureEnabled('shop'))
            <li>
                <a dusk="topnav-deliveries" href="{{route('user.deliveries')}}" class="{{ GameserverApp\Helpers\RouteHelper::isCurrentRoute('user.deliveries') ? 'orange' : '' }}">
                    Deliveries
                </a>
            </li>
        @endif

        @if(SiteHelper::featureEnabled('supporter_tiers'))
            <li>
                <a dusk="topnav-subscriptions" href="{{route('subscription.index')}}" class="{{ GameserverApp\Helpers\RouteHelper::isCurrentRoute('subscription.index') ? 'orange' : '' }}">
                    Subscriptions
                </a>
            </li>
            <li>
                <a dusk="topnav-invoices" href="{{route('user.invoices')}}" class="{{ GameserverApp\Helpers\RouteHelper::isCurrentRoute('user.invoices') ? 'orange' : '' }}">
                    Invoices
                </a>
            </li>
        @endif

        <li>
            <a dusk="topnav-settings" href="{{route('user.settings')}}" class="{{ GameserverApp\Helpers\RouteHelper::isCurrentRoute('user.settings') ? 'orange' : '' }}">
                Settings
            </a>
        </li>
        <li role="separator" class="divider"></li>
        <li>
            <a href="{{route('auth.logout')}}" dusk="topnav-logout">
                Logout
            </a>
        </li>
    </ul>
</div>