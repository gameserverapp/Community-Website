@component('partials.v3.frame', [
    'type' => 'basic',
    'title' => '<span class="label label-theme alternative">Forum</span> &nbsp; <a href="' . $item->url . '">' . $item->thread->title . '</a>'
])

    <p>
        {{str_limit(strip_tags(
            Markdown::convertToHtml($item->content)
        ), 200)}}
    </p>

    <div class="meta">
        <time datetime="{{$item->date('created_at')->toDateTimeString()}}" itemprop="datePublished">
            {{ $item->date('created_at')->diffForHumans() }}
        </time>
        &nbsp;
        <span>
            <div class="count badge"  itemprop="interactionStatistic" itemscope itemtype="http://schema.org/InteractionCounter">
                <link itemprop="interactionType" href="http://schema.org/CommentAction" />
                @if($item->thread->reply_count == 1)
                    1 reply
                @else
                    {{$item->thread->reply_count}} replies
                @endif
            </div>
        </span>
    </div>

@endcomponent