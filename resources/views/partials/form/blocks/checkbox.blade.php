<label>
    <input type="checkbox" @if(old($name) == $value) checked @endif name="{{$name}}" value="1"> &nbsp; {{$value}}
</label><br>