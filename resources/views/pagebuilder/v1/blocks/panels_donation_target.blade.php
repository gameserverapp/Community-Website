@component('partials.v3.frame', [
    'title' => 'Monthly donation target &nbsp; <span class="label label-theme alternative">' . $target->total_income . ' / ' . $target->target . '</span>',
    'class' => 'center-title no-bottom-margin',
])

    @if(isset($block['text']) and !empty($block['text']))
        <div class="row">
            <div class="col-xs-10 center-block text-center">
                    <p>
                        {{$block['text']}}
                    </p>
            </div>
        </div>

        <br><br>
    @endif

    <div class="row">
        <div class="col-xs-1 text-right">
            0
        </div>

        <div class="col-xs-10 text-center">

            <div class="progress progress-big">
                <div class="progress-bar" role="progressbar" aria-valuenow="{{$target->percentage}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$target->percentage}}%;">
                </div>
                <span class="percentage">{{$target->percentage}}%</span>
            </div>

        </div>

        <div class="col-xs-1">
            {{$target->target}}
        </div>
    </div>

@endcomponent