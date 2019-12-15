<div class="row">

@php
$title = '';
@endphp

    @foreach($row['content'] as $key => $block)
        <div class="col-sm-{{$block['size'] or 12}}">

        @php
        if($block['type'] == 'title') {
            $title = $block['value'];
        } elseif($title) {
            $block['title'] = $title;
            unset($title);
        }

        $name = '';

        if(isset($block['title'])) {
            $name = $rowId . '_' . urlencode($block['title']);
        }

        @endphp

            @include('partials.form.blocks.' . $block['type'], [
                'value' => isset($block['value'])? $block['value'] : '',
                'name' => $name
            ])
        </div>
    @endforeach
</div>
