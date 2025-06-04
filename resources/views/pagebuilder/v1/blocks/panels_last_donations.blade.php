<?php
use GameserverApp\Helpers\SiteHelper;
?>

@component('partials.v3.frame', [
    'title' => '<i class="fa fa-heart"></i> Recent donations',
    'class' => 'no-padding center-title no-bottom-margin',
    'content_style' => 'min-height: 300px;'
])
    <table class="table">
        <thead>
        <tr>
            <th>Name</th>
            <th>Amount</th>
        </tr>
        </thead>
        <tbody>
        @forelse( $sales as $sale )
            <tr>
                <td>
                    {!! $sale->user()->showLink() !!}
                </td>
                <td>
                    {{$sale->currency()}} {{$sale->amount()}}
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center">

                    @if(SiteHelper::featureEnabled('all_sales'))

                        <br><br>
                        No donations yet!
                        <br><br>
                        <br>
                    @else
                        <br><br>
                        <div class="alert alert-warning">
                            This feature is disabled.
                        </div>
                    @endif
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
@endcomponent