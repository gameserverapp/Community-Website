<?php
$server = collect($servers)->filter(function($item) use ($value) {
    return $item->id == $value;
});
?>

@if($server->count())
    <?php
    $server = (object) $server->first();
    ?>
    <div class="server-container no-slider">
        @include('partials.v3.server')
    </div>
@endif