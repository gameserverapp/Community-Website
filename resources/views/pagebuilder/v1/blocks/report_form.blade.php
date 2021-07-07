@if(auth()->check())
    <form method="post" action="{{route('report.submit')}}">
        {{csrf_field()}}
@endif

<?php
$footer = '<button type="submit" ' . (!auth()->check() ? 'disabled' : '' ) . ' class="btn btn-theme small"><span>Submit</span></button>';
?>

@component('partials.v3.frame', ['title' => $value, 'class' => 'no-bottom-margin', 'footer' => $footer])

    @if(!auth()->check())
        <div class="alert alert-warning">
            Please <a href="{{route('auth.login')}}">login</a> to submit your application.<br>
            You will be requested to log into your steam account, so we can verify you own the Steam account.
        </div>
    @endif

    {!! Markdown::convertToHtml($block['description']) !!}
    <hr>

    <div class="form-group">
        <label>Select type</label>
        <select class="form-control" name="type">
            @foreach($block['types'] as $reportType)
                <option value="{{$reportType['id']}}" @if(old('types') == $reportType['id']) selected @endif>{{$reportType['name']}}</option>
            @endforeach
        </select>
    </div>

    @isset($block['character'])
        <div class="form-group">
            <label>Reporting about</label>
            <select class="form-control" name="reporting_char">
                <option value=""> - Nobody - </option>
                <option value="{{$block['character']['id']}}" selected>{{$block['character']['name']}}</option>
            </select>
        </div>
    @endif

    <div class="form-group">
        <label>What do you want to report (required)</label>
        <textarea name="comment" style="height:100px;" class="form-control">{{old('comment')}}</textarea>
    </div>

@endcomponent

@if(auth()->check())
    </form>
@endif