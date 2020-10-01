@component('partials.v3.frame', ['class' => 'category'])
    <div class="row">
        <div class="col-md-12">
            <a href="{{ Forum::route('category.show', $category) }}">
                <h2>{{ $category->title }} &raquo;</h2>
            </a>
        </div>
    </div>

    <div class="row">
        <div class="left col-md-6">
            <div class="info">

                <p>{{ $category->description }}</p>

                <ul>
                    <li>
                        Threads:
                        <span>
                        @if (!$category->children()->isEmpty())
                                {{ $category->children()->sum('thread_count') + $category->thread_count }}
                            @else
                                {{ $category->thread_count }}
                            @endif
                    </span>
                    </li>
                    <li>
                        Posts:
                        <span>
                        @if (!$category->children()->isEmpty())
                                {{ $category->children()->sum('post_count') + $category->post_count }}
                            @else
                                {{ $category->post_count }}
                            @endif
                    </span>
                    </li>
                </ul>


                @if (!$category->children()->isEmpty())
                    <div class="children">
                        @foreach ($category->children() as $subcategory)
                            <a href="{{ Forum::route('category.show', $subcategory) }}"><i
                                        class="fa fa-folder-open"></i><span>{{ $subcategory->title }}</span></a>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <div class="right col-md-6">
            <div class="row">
                <div class="col-md-12">

                    @if ($category->newestThread)
                        <span class="well first thread-well">
                        <span>Latest thread:</span>
                        <a href="{{ Forum::route('thread.show', $category->newestThread) }}">
                            <span>{{ str_limit( $category->newestThread->title, 25, '...') }}</span>
                            <time datetime="{{ $category->newestThread->date('updated_at')->toDateTimeString() }}">
                                [{{ $category->newestThread->date('updated_at')->diffForHumans() }}]
                            </time>
                        </a>
                    </span>
                    @endif
                </div>
                <div class="col-md-12">

                    @if ($category->latestActiveThread)
                        <span class="well thread-well">
                        <span>Last reply:</span>
                        <a href="{{ Forum::route('thread.show', $category->latestActiveThread->lastPost) }}">
                            <span>{{ str_limit( $category->latestActiveThread->title, 25, '...') }}</span>
                            <time datetime="{{ $category->latestActiveThread->lastPost->date('updated_at')->toDateTimeString() }}">
                                [{{ $category->latestActiveThread->lastPost->date('updated_at')->diffForHumans() }}]
                            </time>
                        </a>
                    </span>
                    @endif
                </div>
            </div>

        </div>

    </div>
@endcomponent