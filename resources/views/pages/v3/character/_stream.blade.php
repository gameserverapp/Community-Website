<div class="panel panel-default stream">
    <div class="panel-heading">
        <h3 class="panel-title">
            Watch {{$character->name}} LIVE!
        </h3>

        <a href="https://twitch.tv/{{$character->user->twitchUsername()}}" target="_blank" rel="nofollow"
           class="label label-default">
            Subscribe
            <i class="fa fa-heart" aria-hidden="true"></i>
        </a>
    </div>

    <div class="panel-body">
        <iframe
                src="https://player.twitch.tv/?channel={{$character->user->twitchUsername()}}"
                height="477"
                width="100%"
                frameborder="0"
                scrolling="no"
                allowfullscreen="true">
        </iframe>
    </div>
</div>
