<?php
use GameserverApp\Models\Order;
?>
@include('partials.frame.simple-top')
<div class="panel panel-default">
    <!-- Default panel contents -->
    <div class="panel-heading">
        Subscription <small>({{$subscription->id()}})</small>
    </div>
    <div class="panel-body">
        <div class="row">

            <div class="col-md-6">
                <h4>Subscription details</h4>

                <table class="table">
                    <tr>
                        <td>
                            Content
                        </td>
                        <td>
                            <a href="{{$subscription->relatableUrl()}}">{{$subscription->relatableName()}}</a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Price
                        </td>
                        <td>
                            {{$subscription->currency()}} {{$subscription->amount()}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Status
                        </td>
                        <td>
                            {{$subscription->status}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Started
                        </td>
                        <td>
                            {{$subscription->created_at}}
                        </td>
                    </tr>
                </table>
            </div>

            <div class="col-md-6">
                <h4>Subscription settings</h4>
                @if($subscription->expired())
                    <div class="alert alert-warning">
                        This subscription has been cancelled and can not longer be changed.
                    </div>
                @else
                    @if($subscription->hasCharacter())
                        <form method="post" action="{{route('subscription.change_character', $subscription->id())}}">
                            <div class="form-group">
                                <label>
                                    Deliver content to:
                                </label>
                                <select>
                                    <option selected id="{{$subscription->character->id}}">{{$subscription->character->name()}} [Current]</option>

                                    @foreach($subscription->availableCharacters() as $character)
                                        <option id="{{$character->id}}">{{$character->name()}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </form>
                    @endif
                @endif

            </div>

        </div>
    </div>
</div>
@include('partials.frame.simple-bottom')