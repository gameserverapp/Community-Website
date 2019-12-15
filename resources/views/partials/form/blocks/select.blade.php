<select name="{{$name}}">
    <?php
    $options = explode("\r\n", $value);
    ?>
    @foreach($options as $option)
        <option @if(old($name) == $value) selected @endif value="{{$option}}">{{ucfirst($option)}}</option>
    @endforeach
</select>