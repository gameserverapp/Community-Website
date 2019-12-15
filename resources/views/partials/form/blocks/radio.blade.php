<?php
$options = explode("\r\n", $value);
?>
@foreach($options as $option)
    <label>
        <input type="radio" @if(old($name) == $value) checked @endif name="{{$name}}" value="{{$option}}"> &nbsp; {{ucfirst($option)}}
    </label><br>
@endforeach