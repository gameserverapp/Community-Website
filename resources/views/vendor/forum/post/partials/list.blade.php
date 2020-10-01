<?php
use GameserverApp\Helpers\SiteHelper;
?>

@component('partials.v3.frame', ['class' => 'no-padding'])
<div id="post-{{ $post->sequence }}" class="forum-post {{ $post->trashed() ? 'deleted' : '' }}"  itemscope itemtype="http://schema.org/Comment">
    <div class="persona">

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

            <div class="name">
                <h5 class="title">
                    @if($post->author->banned() or !SiteHelper::featureEnabled('user_page'))
                        {!! $post->author->showName() !!}
                    @else
                        {!! $post->author->showLink() !!}
                    @endif
                </h5>
            </div>

            <div class="role">
                {!! $post->author->displayRoleLabel() !!}
            </div>

            <div class="meta">
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
        </div>

        @if(
            $charsToShow and
            SiteHelper::featureEnabled('character_page') and
            !$post->author->banned()
        )
            <div class="characters">
                <ul>
                    @foreach( $post->author->characters->take(3) as $char )
                        <li class="character">
                            <div class="char_pic" style="background-image:url('{{$char->image()}}')"></div>
                            {!! $char->showLink(['suffix' => ' (' . $char->level . ')']) !!}
                        </li>

                    @endforeach
                </ul>
            </div>
        @endif

    </div>

    <div class="post-content">
        <div class="content">
            @if ($post->trashed())
                <span class="label label-danger">{{ trans('forum::general.deleted') }}</span>
            @else
                <div class="markdown-content" itemprop="text">
                    {!! Markdown::convertToHtml($post->content) !!}
                </div>
            @endif
        </div>


        <div class="bottom-nav">

            <span class="posted">
                {{ trans('forum::general.posted') }}
                <time datetime="{{ $post->date('created_at')->toDateTimeString() }}" itemprop="dateCreated">{{ $post->date('created_at')->diffForHumans() }}</time>
                @if ($post->hasBeenUpdated())
                    | {{ trans('forum::general.last_updated') }}
                    <time datetime="{{ $post->date('created_at')->toDateTimeString() }}" itemprop="dateModified">{{ $post->date('updated_at')->diffForHumans() }}</time>
                @endif
            </span>

            @if (!$post->trashed())
                <span class="edit">
                    @can ('edit', $post)
                        | <a href="{{ Forum::route('post.edit', $post) }}">{{ trans('forum::general.edit') }}</a>
                    @endcan
                </span>

                <span class="delete">
                    @if (!$post->isFirst)
                        @can ('delete', $post)
                            <form style="display: inline-block" action="{{ Forum::route('post.update', $post) }}" method="POST" data-actions-form>
                            {!! csrf_field() !!}
                                {!! method_field('delete') !!}

                                | <button type="submit" class="btn-link btn-xs">Delete</button>
                            </form>
                        @endcan
                    @endif
                </span>
            @endif

        </div>
    </div>
</div>
@endcomponent