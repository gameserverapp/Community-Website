@component('partials.v3.frame', [
    'title' => '<i class="fa fa-thumbs-up"></i> Top 5 voters',
    'class' => 'no-padding center-title no-bottom-margin',
    'content_style' => 'min-height: 300px;'
])
    <table class="table">
        <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Total votes</th>
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
                    {{$user->votes()}}
                </td>
            </tr>

            <?php
            $count++;
            ?>
        @empty
            <tr>
                <td colspan="5" class="text-center">
                    <br><br>
                    No votes yet!
                    <br><br>
                    <br>
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
@endcomponent