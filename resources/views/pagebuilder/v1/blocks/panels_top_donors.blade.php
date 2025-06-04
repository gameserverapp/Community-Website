<?php
use GameserverApp\Helpers\SiteHelper;
?>

@component('partials.v3.frame', [
    'title' => '<i class="fa fa-heart"></i> Top 5 donors',
    'class' => 'no-padding center-title no-bottom-margin',
    'content_style' => 'min-height: 300px;'
])
    <table class="table">
        <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Total donated</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $count = 1;
        ?>
        @forelse( $users as $user )
            <tr>
                <td>{{$count}}</td>
                <td>
                    {!! $user->showLink() !!}
                </td>
                <td>
                    {{$user->donatedAmount()}}
                </td>
            </tr>

            <?php
            $count++;
            ?>
        @empty
            <tr>
                <td colspan="5" class="text-center">

                    @if(SiteHelper::featureEnabled('top_donors'))
                        <br><br>
                        No donors yet!
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