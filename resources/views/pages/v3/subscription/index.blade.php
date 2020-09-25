@extends('layouts.v3.default', [
    'page' => [
        'title' => translate('subscriptions', 'Subscriptions'),
        'description' => 'Manage your subscriptions',
        'class' => 'article-index'
    ],

    'breadcrumbs' => [
        [
            'title' => auth()->user()->name(),
            'route' => route('user.settings', 'me')
        ],
        [
            'title' => translate('subscriptions', 'Subscriptions')
        ]
    ]
])

@section('page_content')
    <div class="row">
        <div class="col-md-12 text-center">
            <h1 class="main-title">{{translate('subscriptions', 'Subscriptions')}}</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-10 center-block">
            @forelse($subscriptions as $subscription)
                @include('pages.v3.subscription._subscription')
            @empty

                @component('partials.v3.frame')
                    <h3>You don't have any subscriptions yet</h3>
                @endcomponent
            @endforelse
        </div>

        <div class="paginate">
            {!! $subscriptions->links() !!}
        </div>

    </div>



@stop