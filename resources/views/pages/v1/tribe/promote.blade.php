@extends('layouts.v2.banner', [
    'page' => [
        'title' => 'Members ' . $tribe->name,
        'description' => '',
        'class' => 'tribe promote'
    ],
    'banner' => [
        'size' => 'small',
        'animated' => true,
        'text-only' => true,
        'vertical-align' => true,
        'navigation' => 'pages.v1.tribe.partials.navigation',
        'background' => [
            'tribe' => $tribe->bannerBackground()
        ]
    ]
])

@section('banner_content')
    Promote your {{ GameserverApp\Helpers\SiteHelper::groupName()}}!
@endsection

@section('page_content')

    <div class="container introtext">
        <div class="row">
            <div class="col-sm-8 center-block text-center">
                <h2>
                    Expand your {{ GameserverApp\Helpers\SiteHelper::groupName()}} and grow to a busy town-size community!<br>
                    Here are some tips to expand your tribe
                </h2>
            </div>
        </div>
    </div>

    <div class="container-fluid fulldark">
        <div class="container">
            <div class="row ">
                <div class="col-md-6">
                    <h2>Setup your {{ GameserverApp\Helpers\SiteHelper::groupName()}} page</h2>
                    <p>
                        Make sure your prospect {{ GameserverApp\Helpers\SiteHelper::groupName()}} members are able to read about your {{ GameserverApp\Helpers\SiteHelper::groupName()}}.
                    </p>
                    <p>
                        You can easily setup an <strong>'About' message on your {{ GameserverApp\Helpers\SiteHelper::groupName()}} page</strong>. With the 'About'
                        message, its very easy for new people to see what your {{ GameserverApp\Helpers\SiteHelper::groupName()}} is up to.
                    </p>
                    @if(
                        auth()->check() and
                        $tribe->hasOwners() and
                        $tribe->isOwner(auth()->user())
                    )
                        <p>
                            Since you are the {{ GameserverApp\Helpers\SiteHelper::groupName()}} owner, you can setup the 'About' message, on the <a
                                    href="{{route('group.settings', $tribe->id)}}">settingspage of your {{ GameserverApp\Helpers\SiteHelper::groupName()}}</a>.
                        </p>
                    @endif
                </div>
                <div class="col-md-6">
                    <h2>&nbsp;</h2>
                    <p>
                        When you have the 'About' message setup, you can start <strong>sharing the URL of your
                            {{ GameserverApp\Helpers\SiteHelper::groupName()}} page</strong>.
                    </p>
                </div>
            </div>

            <div class="row share">
                <div class="col-md-8 center-block">
                    <h2>Your {{ GameserverApp\Helpers\SiteHelper::groupName()}} share URL:</h2>
                    <input class="shareurl"
                           onClick="this.setSelectionRange(0, this.value.length)"
                           type="text" value="{{route('group.show', $tribe->id)}}">
                </div>

            </div>
        </div>

    </div>

    <div class="container wheretoshare">
        <div class="row defaultcontent">
            <div class="col-md-6">
                <h2>OK, so you have setup the {{ GameserverApp\Helpers\SiteHelper::groupName()}} page...</h2>
                <p>
                    Now its time to put the page to work! <strong>Start sharing</strong> your {{ GameserverApp\Helpers\SiteHelper::groupName()}}'s page on different discussion boards.
                </p>
            </div>
        </div>
    </div>

@endsection