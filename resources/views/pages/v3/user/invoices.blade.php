<?php
use GameserverApp\Models\Delivery;
use GuzzleHttp\Exception\ClientException;
?>

@extends('layouts.v3.default', [
    'page' => [
        'title' => translate('invoices', 'Invoices'),
        'description' => 'Invoices',
        'class' => 'user-single',
        'attributes' => ''
    ],
])

@section('page_content')
    @include('pages.v3.user._header')

    <div class="row">
        <div class="col-md-10 center-block">

            @component('partials.v3.frame', ['class' => 'no-padding'])
                <table class="table">
                    <thead>
                    <tr>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Order</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>

                    @if(
                        $invoices instanceof ClientException and
                        $invoices->getCode() == 401
                    )
                        <tr>
                            <td colspan="4">
                                <br>
                                <div class="alert alert-warning">
                                    <strong>Invoices unavailable</strong><br>
                                    Contact the owner of the community to activate the invoices.
                                </div>
                            </td>
                        </tr>
                    @else
                        @forelse($invoices as $item)
                            <tr>
                                <td>
                                    {{$item->transactionDate()->format('d F Y H:i')}}
                                </td>
                                <td>
                                    {{$item->currency()}}
                                    {{$item->amount()}}
                                </td>
                                <td>
                                    @if($item->hasRelatable())
                                        {{$item->relatable()->name()}}

                                        @if($item->isSubscriptionSale())
                                            <span class="label label-primary">
                                                Subscription sale
                                            </span>
                                        @endif

                                    @else
                                        ?
                                    @endif
                                </td>
                                <td align="right">
                                    @if($item->hasInvoiceLink())
                                        <a href="{{route('user.invoices.download', ['uuid' => auth()->user()->id, 'sale_id' => $item->id()])}}" target="_blank" class="btn btn-default">Download receipt</a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3"><em>No invoices yet.</em></td>
                            </tr>
                        @endforelse
                    @endif

                    </tbody>
                </table>
            @endcomponent

            @if(!$invoices instanceof ClientException)
                <div class="paginate">
                    {!! $invoices->links() !!}
                </div>
            @endif
        </div>

        </div>
    </div>

@stop