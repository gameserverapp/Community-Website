@include('partials.frame.simple-top')
<div class="panel panel-default">
    <!-- Default panel contents -->
    <div class="panel-heading">
        Player transaction
    </div>

    <table class="table">
        <thead>
        <tr>
            <th>Date</th>
            <th>Type</th>
            <th>+/-</th>
            <th></th>
            <th width="50%">Description</th>
        </tr>
        </thead>
        <tbody>

        @forelse($transactions as $transaction)
            <tr>
                <td>{{$transaction->date('created_at')->format('d-m-Y H:i')}}</td>
                <td>
                    @if( $transaction->transactionType() == 'purchase' )
                        <div class="label label-default">Token purchase</div>
                    @elseif( $transaction->transactionType() == 'shop' )
                        <div class="label label-info">Shop purchase</div>
                    @elseif( $transaction->transactionType() == 'player' )
                        <div class="label label-warning">Player to Player</div>
                    @elseif( $transaction->transactionType() == 'admin' )
                        <div class="label label-champ">Admin</div>
                    @else
                        <div class="label label-default">Unknown</div>
                    @endif
                </td>
                <td>
                    @if( $transaction->transactionValue() > 0 )
                        <div class="label label-success">
                            +{{$transaction->transactionValue()}}
                        </div>
                    @else
                        <div class="label label-danger">
                            {{$transaction->transactionValue()}}
                        </div>
                    @endif

                </td>
                <td>
                    @if( $transaction->transactionValue() > 0 )
                        @if(is_null($transaction->sender) )
                            <em>from</em>
                            <strong>{{GameserverApp\Helpers\SiteHelper::name()}}</strong>
                        @else
                            <em>from</em>
                            <strong>{!! $transaction->sender->showLink() !!}</strong>
                        @endif
                    @elseif(isset($transaction->sender))
                        <em>to</em>
                        <strong>{!! $transaction->sender->showLink() !!}</strong>
                    @else
                        -
                    @endif
                </td>
                <td>{{$transaction->description}}</td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center">
                    <em>No transactions found</em>
                </td>
            </tr>

        @endforelse

        </tbody>
    </table>
</div>
@include('partials.frame.simple-bottom')