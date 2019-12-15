<div class="col-sm-10 center-block ">
    <ul class="nav nav-tabs">

        {{--todo hier moet geen menu meer, maar per conversatie gewoon een overzicht. geen inbox en outbox meer--}}


        <li class="{{ GameserverApp\Helpers\RouteHelper::isCurrentRoute('message.inbox') ? 'active' : '' }}">
            <a href="{{route('message.inbox')}}">
                Inbox
                <span class="label label-default">
                    {{auth()->user()->unreadMessagesCount()}}
                </span>
            </a>
        </li>
        <li class="{{ GameserverApp\Helpers\RouteHelper::isCurrentRoute('message.outbox') ? 'active' : '' }}">
            <a href="{{route('message.outbox')}}">
                Outbox
            </a>
        </li>
    </ul>
</div>