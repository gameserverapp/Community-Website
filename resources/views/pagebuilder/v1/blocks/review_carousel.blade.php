<article class="review-carousel">
    @if(isset($block['title']) and !empty($block['title']))
        <div class="row">
            <div class="col-md-12 text-center">
                <h1>
                    {{$block['title']}}
                </h1>
            </div>
        </div>
    @endif
    <div class="row">
        <div class="owl-theme review-carousel" id="reviewCarousel" data-count="{{$block['items_per_slide'] ?? 2}}">
            @forelse($reviews as $review)
                <div class="review-container">
                    @include('partials.v3.review', [
                        'slider' => true
                    ])
                </div>
            @empty

            @endforelse
        </div>
    </div>
</article>