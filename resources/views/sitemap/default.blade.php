<?php echo '<?xml version="1.0" encoding="UTF-8"?>' ?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

    <url>
        <loc>{{ URL::route("home") }}</loc>
        <lastmod>{{ gmdate(DateTime::W3C, strtotime(Carbon\Carbon::now()->subMinutes(2)->subSeconds(rand(0,30)))) }}</lastmod>
        <changefreq>hourly</changefreq>
        <priority>0.8</priority>
    </url>

    <url>
        <loc>{{ URL::route("news.index") }}</loc>
        <lastmod>{{ gmdate(DateTime::W3C, strtotime($posts->first()->updated_at)) }}</lastmod>
        <changefreq>daily</changefreq>
        <priority>0.7</priority>
    </url>

    <url>
        <loc>{{ URL::route("supplies.index") }}</loc>
        <changefreq>monthly</changefreq>
        <priority>0.4</priority>
    </url>

    <url>
        <loc>{{ URL::route("page.pickup") }}</loc>
        <changefreq>monthly</changefreq>
        <priority>0.4</priority>
    </url>

    <url>
        <loc>{{ URL::route("travel.character") }}</loc>
        <changefreq>monthly</changefreq>
        <priority>0.4</priority>
    </url>

    @foreach($packages as $package)
        <url>
            <loc>{{ route('supplies.show', $package->uuid) }}</loc>
            <lastmod>{{ gmdate(DateTime::W3C, strtotime($package->updated_at)) }}</lastmod>
            @if($package->updated_at > Carbon::now()->subDays(10))
                <changefreq>daily</changefreq>
                <priority>0.9</priority>
            @else
                <changefreq>monthly</changefreq>
                <priority>0.4</priority>
            @endif
        </url>
    @endforeach

    @foreach($forumThreads as $thread)
        <url>
            <loc>{{ Forum::route('thread.show', $thread) }}</loc>
            <lastmod>{{ gmdate(DateTime::W3C, strtotime($thread->updated_at)) }}</lastmod>
            @if($thread->updated_at > Carbon::now()->subDays(10))
                <changefreq>daily</changefreq>
                <priority>0.9</priority>
            @else
                <changefreq>monthly</changefreq>
                <priority>0.4</priority>
            @endif
        </url>
    @endforeach

    @foreach($posts as $post)
        <url>
            <loc>{{ URL::route("news.show", ['id' => $post->id, 'slug' => $post->slug]) }}</loc>
            <lastmod>{{ gmdate(DateTime::W3C, strtotime($post->updated_at)) }}</lastmod>
            <changefreq>daily</changefreq>
            <priority>0.8</priority>
        </url>
    @endforeach

    @foreach($characters as $character)
        <url>
            <loc>{{ URL::route("character.view", [$character->uuid]) }}</loc>
            <lastmod>{{ gmdate(DateTime::W3C, strtotime($character->updated_at)) }}</lastmod>
            <changefreq>daily</changefreq>
            <priority>0.7</priority>
        </url>
    @endforeach

    @foreach($tribes as $tribe)
        <url>
            <loc>{{ URL::route("tribe.view", [$tribe->uuid]) }}</loc>
            <lastmod>{{ gmdate(DateTime::W3C, strtotime($tribe->updated_at)) }}</lastmod>
            <changefreq>daily</changefreq>
            <priority>0.7</priority>
        </url>
        <url>
            <loc>{{ URL::route("tribe.members", [$tribe->uuid]) }}</loc>
            <lastmod>{{ gmdate(DateTime::W3C, strtotime($tribe->updated_at)) }}</lastmod>
            <changefreq>daily</changefreq>
            <priority>0.5</priority>
        </url>
    @endforeach

    @foreach($users as $user)
        <url>
            <loc>{{ URL::route("account.dashboard", [$user->uuid]) }}</loc>
            <lastmod>{{ gmdate(DateTime::W3C, strtotime($user->updated_at)) }}</lastmod>
            <changefreq>daily</changefreq>
            <priority>0.7</priority>
        </url>
        <url>
            <loc>{{ URL::route("account.tribes", [$user->uuid]) }}</loc>
            <lastmod>{{ gmdate(DateTime::W3C, strtotime($user->updated_at)) }}</lastmod>
            <changefreq>daily</changefreq>
            <priority>0.4</priority>
        </url>
    @endforeach

    @foreach($forumCategories as $category)
        <url>
            <loc>{{ Forum::route('category.show', $category) }}</loc>
            <lastmod>{{ gmdate(DateTime::W3C, strtotime($category->updated_at)) }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.3</priority>
        </url>
    @endforeach

</urlset>