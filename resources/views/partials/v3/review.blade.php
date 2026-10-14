<div class="review-item">

    <div class="review-item__score">
        <?php
        switch ($review->score()) {
            case 1:
                ?>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star-o"></i>
                    <i class="fa fa-star-o"></i>
                    <i class="fa fa-star-o"></i>
                    <i class="fa fa-star-o"></i>
                    <?php
                break;

            case 2:
                ?>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star-o"></i>
                    <i class="fa fa-star-o"></i>
                    <i class="fa fa-star-o"></i>
                    <?php
                break;

            case 3:
                ?>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star-o"></i>
                    <i class="fa fa-star-o"></i>
                    <?php
                break;

            case 4:
                ?>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star-o"></i>
                    <?php
                break;

            case 5:
                ?>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <?php
                break;

            default:
                ?>?<?php
               break;
       }
       ?>
    </div>

    <div class="review-item__meta">
        By {!! $review->user()->showLink() !!} on
        {{ $review->postDate()->format('d M Y') }}
    </div>

    @if($review->hasComment())
        <div class="review-item__comment">
            {!! $review->commentWithBr() !!}
        </div>
    @endif
</div>
