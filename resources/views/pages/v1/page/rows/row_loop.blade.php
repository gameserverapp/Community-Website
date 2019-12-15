<div class="row
@if(
    isset($row['settings']['vertical_align']) and
    $row['settings']['vertical_align']
)
        display-table nowidth valign-{{$row['settings']['vertical_align']}}
@endif
    textcolor-{{$row['settings']['text_color'] or 'dark'}}
    @if($rowTemplate == 'header' and (!isset($row['settings']['padding']) or $row['settings']['padding'] < 2)) padding-2 @else
    padding-{{$row['settings']['padding'] or '2'}} @endif
    defaultcontent">

    @foreach($row['content'] as $key => $block)
        <div class="col-md-{{$block['size'] or 12}}
        @if(isset($row['settings']['vertical_align']))table-cell @endif
        @if(isset($block['align'])) text-{{$block['align']}} @endif">
            @include('pages.v1.page.blocks.' . $block['type'], [
                'value' => isset($block['value'])? $block['value'] : ''
            ])
        </div>
    @endforeach
</div>
