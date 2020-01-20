<?php
use GameserverApp\Helpers\SiteHelper;
?>

<tr class="forum-post-decoration-top">
    <td colspan="4">
        <div class="top-left"></div>
        <div class="top-repeat"></div>
        <div class="top-right"></div>
    </td>
</tr>
<tr id="post-{{ $post->sequence }}" class="forum-post {{ $post->trashed() ? 'deleted' : '' }}"  itemscope itemtype="http://schema.org/Comment">
    <td class="forum-post-decoration-left">
        <div class="left-repeat-top"></div>
        <div class="left-repeat-bottom"></div>
    </td>
    <td class="persona">

        <?php
        $charsToShow = false;

        if(!$post->author->banned()) {
            $characters = $post->author->characters;
            $charsToShow = ( count($characters) > 0 );
        }
        ?>

        <div class="person-data @if(!$charsToShow) nochars @endif">
            <div class="thumbnail">
                @if( !empty( $post->author->avatar ) )
                    <img src="{{$post->author->avatar}}">
                @else
                    <img src="https://placehold.it/300?text={{$post->author->name()}}">
                @endif
            </div>

            @if($post->author->banned() or !SiteHelper::featureEnabled('user_page'))
                {!! $post->author->showName() !!}
            @else
                {!! $post->author->showLink() !!}
            @endif

            <div class="role">
                {!! $post->author->displayRoleLabel() !!}
            </div>

            @if($post->author->banned())
                <div class="label label-default">Banned</div>
            @else
                <div class="stats">
                    <div class="joined">
                        Joined: <span>{{$post->author->date('created_at')->diffForHumans()}}</span>
                    </div>
                </div>
            @endif
        </div>
        @if( $charsToShow and SiteHelper::featureEnabled('character_page') )
            <div class="characters">
                <ul>
                    @foreach( $post->author->characters as $char )
                        <li class="character">
                            <div class="char_pic"
                                 style="background-image:url('/img/character/{{$char->characterImage()}}')"></div>
                            {{--{!! characterLink($char, 'small', '', ' (' . $char->level . ')', 12) !!}--}}
                            {!! $char->showLink(['suffix' => ' (' . $char->level . ')']) !!}
                        </li>

                    @endforeach
                </ul>
            </div>
        @endif
    </td>
    <td class="contentwrap">
        <table>
            <tr>
                <td>

                    <div class="bottom-nav">

                        <div class="posted">
                            {{ trans('forum::general.posted') }}
                            <time datetime="{{ $post->date('created_at')->toDateTimeString() }}" itemprop="dateCreated">{{ $post->date('created_at')->diffForHumans() }}</time>
                            @if ($post->hasBeenUpdated())
                                | {{ trans('forum::general.last_updated') }}
                                <time datetime="{{ $post->date('created_at')->toDateTimeString() }}" itemprop="dateModified">{{ $post->date('updated_at')->diffForHumans() }}</time>
                            @endif
                        </div>

                        <div class="edit">
                            @if (!$post->trashed())
                                @can ('edit', $post)
                                    <a href="{{ Forum::route('post.edit', $post) }}">{{ trans('forum::general.edit') }}</a>
                                @endcan
                            @endif
                        </div>

                    </div>
                    <div class="content">
                        @if ($post->trashed())
                            <span class="label label-danger">{{ trans('forum::general.deleted') }}</span>
                        @else
                            <div class="markdown-content" itemprop="text">
                                {!! Markdown::convertToHtml($post->content) !!}
                            </div>
                        @endif
                    </div>
                </td>
            </tr>
        </table>
    </td>
    <td class="forum-post-decoration-right">
        <div class="right-repeat-top"></div>
        <div class="right-repeat-bottom"></div>
    </td>
</tr>
<tr class="forum-post-decoration-bottom">
    <td colspan="4">
        <div class="bottom-left"></div>
        <div class="bottom-repeat"></div>
        <div class="bottom-right"></div>
    </td>
</tr>
<tr class="spacing">
    <td colspan="4"></td>
</tr>

{{--
<tr>
    <td>

    </td>
    <td class="text-muted">
        <span class="pull-right">
            <a href="{{ Forum::route('thread.show', $post) }}">#{{ $post->id }}</a>
            @if (!$post->trashed())
                @can ('reply', $post->thread)
                    - <a href="{{ Forum::route('post.create', $post) }}">{{ trans('forum::general.reply') }}</a>
                @endcan
            @endif
            @if (Request::fullUrl() != Forum::route('post.show', $post))
                - <a href="{{ Forum::route('post.show', $post) }}">{{ trans('forum::posts.view') }}</a>
            @endif
            @if (isset($thread))
                @can ('deletePosts', $thread)
                    @if (!$post->isFirst)
                        <input type="checkbox" name="items[]" value="{{ $post->id }}">
                    @endif
                @endcan
            @endif
        </span>
    </td>
</tr>

--}}