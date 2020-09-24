<?php
$classes = [];

if(
    isset($row['settings']['vertical_align']) and
    $row['settings']['vertical_align']
) {

    $blocked = config('gameserverapp.pagebuilder.disable_vertical_align_for_blocks');

    $hasBlockedBlocksAsChild = array_filter($row['content'], function($item) use ($blocked) {
        return in_array($item['type'], $blocked);
    });

    if(!count($hasBlockedBlocksAsChild)) {
        $classes[] = 'display-table valign-' . $row['settings']['vertical_align'];
    }
}

if(isset($row['settings']['text_color'])) {
    $classes[] = 'textcolor-' . $row['settings']['text_color'];
} else {
    $classes[] = 'textcolor-dark';
}

if(!isset($disable_padding)) {
    if(
        $rowTemplate == 'header' and
        (
            !isset($row['settings']['padding']) or
            $row['settings']['padding'] < 2
        )
    ) {
        $classes[] = 'padding-2';
    } elseif(isset($row['settings']['padding'])) {
        $classes[] ='padding-' . $row['settings']['padding'];
    } else {
        $classes[] = 'padding-2';
    }
}
?>


<div class="row {{implode(' ', $classes)}}">

    @foreach($row['content'] as $key => $block)
        <div class="col-md-{{$block['size'] or 12}}
        @if(isset($row['settings']['vertical_align']))table-cell @endif
        @if(isset($block['align'])) text-{{$block['align']}} @endif">
            @if($block['type'] == 'formbuilder' and !isset($block['name']))
                Could not find a form
            @else
                @include('pagebuilder.v1.blocks.' . $block['type'], [
                    'value' => isset($block['value'])? $block['value'] : ''
                ])
            @endif
        </div>
    @endforeach
</div>
