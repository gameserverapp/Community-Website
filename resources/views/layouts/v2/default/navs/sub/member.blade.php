<?php
use GameserverApp\Helpers\SiteHelper;
?>
<div class="dropdown">
    <span class="btn btn-default btn-small dashboard" data-toggle="dropdown"
       aria-haspopup="true" aria-expanded="true">
        {!! auth()->user()->showLink(['disable_link' => true]) !!}
        <span class="caret"></span>
    </span>
    <ul class="dropdown-menu">

        <?php
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
                             style="background-image:url('/img/character/{{$navChar->characterImage()}}')"></div>
                    </a>
                </li>
            @endif

            @if(SiteHelper::featureEnabled('tribe_page'))
                <li>
                    @if($navChar->hasTribe())
                        <?php $tribe = auth()->user()->lastCharacter()->tribe ?>
                        <a href="{{route('tribe.show', $tribe->id)}}"  class="{{ GameserverApp\Helpers\RouteHelper::isCurrentRoute('tribe.show', $tribe->id) ? 'orange' : '' }}">
                            {!! $tribe->showLink(['disable_link' => true]) !!}
                        </a>
                    @elseif($navChar)
                        <a href="/{{GameserverApp\Helpers\RouteHelper::inspector()}}?search_type=tribe">
                            Find a {{ GameserverApp\Helpers\SiteHelper::groupName()}} &raquo;
                        </a>
                    @endif
                </li>
            @endif
            @if(SiteHelper::featureEnabled('character_page') or SiteHelper::featureEnabled('tribe_page'))
            <li role="separator" class="divider"></li>
            @endif
            <?php
        }
        ?>

        @if(SiteHelper::featureEnabled('tokens'))
            <li>
                <a href="{{route('token.index')}}" class="{{ GameserverApp\Helpers\RouteHelper::isCurrentRoute('token.index') ? 'orange' : '' }}">
                    Tokens
                    <span class="label label-default right">
                        {{auth()->user()->tokenBalance()}}
                    </span>
                </a>
            </li>
        @endif
        {{--

        <li>
            <a href="{{route('news.index')}}" class="news {{ Request::is('news*') ? 'active' : '' }}">
                News & Updates
            </a>
        </li>


        @if( config('championark.subscriptions.enabled') )
            <li>
                <a href="{{route('user.subscription')}}">
                    Subscription

                    @if(auth()->user()->isP2PSubscriptionEndingShortly())
                        <span class="label label-danger right">
                                !
                            </span>
                    @elseif(auth()->user()->hasP2PSubscription())
                        <span class="label label-success right">
                                <i class="fa fa-check" aria-hidden="true"></i>
                            </span>
                    @endif
                </a>
            </li>
        @endif
 --}}
        @if(GameserverApp\Helpers\RouteHelper::rules() != false)
            <li>
                <a href="{{GameserverApp\Helpers\RouteHelper::rules()}}">
                    <span>Server rules</span>
                </a>
            </li>
        @endif

        <li>
            <a href="{{route('user.settings', auth()->id())}}" class="{{ GameserverApp\Helpers\RouteHelper::isCurrentRoute('user.settings', auth()->id()) ? 'orange' : '' }}">
                Settings
            </a>
        </li>
        <li role="separator" class="divider"></li>
        <li>
            <a href="{{route('auth.logout')}}">
                Logout
            </a>
        </li>
    </ul>
</div>