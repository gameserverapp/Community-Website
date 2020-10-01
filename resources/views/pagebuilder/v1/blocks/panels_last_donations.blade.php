@component('partials.v3.frame', [
    'title' => '<i class="fa fa-heart"></i> Recent donations',
    'class' => 'no-padding center-title no-bottom-margin',
    'content_style' => 'min-height: 300px;'
])
    <table class="table">
        <thead>
        <tr>
            <th></th>
            <th>#</th>
            <th>Name</th>
            <th>Amount</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $count = 1;
        ?>
        @forelse( $sales as $sale )
            <tr>
                <td></td>
                <td>{{$count}}</td>
                <td>
                    {!! $sale->user()->showLink() !!}
                </td>
                <td>
                    {{$sale->currency()}} {{$sale->amount()}}
                </td>
            </tr>

            <?php
            $count++;
            ?>
        @empty
            <tr>
                <td colspan="5" class="text-center">
                    <br><br>
                    No donations yet!
                    <br><br>
                    <br>
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
@endcomponent