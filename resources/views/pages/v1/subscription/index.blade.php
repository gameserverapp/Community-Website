@extends('layouts.v2.banner', [
    'page' => [
        'title' => 'Subscriptions',
        'description' => '',
        'class' => 'subscriptions'
    ],
    'banner' => [
        'size' => 'small',
        'text-only' => false,
        'vertical-align' => true,
    ]
])

@section('banner_content')

    @include('pages.v1.subscription.partials.banner')
@stop

@section('page_content')

    <div class="container">
        <div class="row defaultcontent">

            @forelse($subscriptions as $subscription)
                @include('pages.v1.subscription.partials.list')
            @empty
                <h1>You don't have any subscriptions yet</h1>
            @endforelse

            <div class="paginate">
                {!! $subscriptions->links() !!}
            </div>
        </div>
    </div>

@stop