@extends('layouts.v3.default', [
    'page' => [
        'title' => translate('subscriptions', 'Subscriptions'),
        'description' => 'Manage your subscriptions',
        'class' => 'user-single article-index'
    ]
])

@section('page_content')
    @include('pages.v3.user._header')

    <div class="row">
        <div class="col-md-10 center-block">

            <div class="alert alert-warning">
                If you just ordered a subscription, it can take up to 5 minutes before it shows up here.
            </div>

            @forelse($subscriptions as $subscription)
                @include('pages.v3.user.subscription._subscription')
            @empty

                @component('partials.v3.frame')
                    <div class="text-center">
                        <em>You don't have any subscriptions yet</em>
                    </div>
                @endcomponent
            @endforelse
        </div>

        <div class="paginate">
            {!! $subscriptions->links() !!}
        </div>

    </div>



@endsection